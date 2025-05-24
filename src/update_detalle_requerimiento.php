<?php
require 'db.php'; 

function emptyToNull($value) {
    return empty($value) ? null : $value;
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$success = false;
$errorMessage = '';


// Handle POST request for updates
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['E_id'])) {
    $id = $_POST['E_id'];
    $requerimiento_id = $_POST['E_REQUERIMIENTO_ID'] ?? null;

    // Process form data
    $data = [
        'TIPO_DOC' => $_POST['E_TIPO_DOC'] ?? null,
        'N_DOCUMENTO' => !empty($_POST['E_N_DOCUMENTO']) ? $_POST['E_N_DOCUMENTO'] : null,
        'AREA_USUARIA' => $_POST['E_AREA_USUARIA'] ?? null,
        'F_EMISION' => $_POST['E_F_EMISION'] ?? null,
        'AREA_RECEPTORA' => $_POST['E_AREA_RECEPTORA'] ?? null,
        'F_RECEPCION' => $_POST['E_F_RECEPCION'] ?? null,
        'SINTESIS_DEL_ASUNTO' => $_POST['E_SINTESIS_DEL_ASUNTO'] ?? null,
        'F_EDICION' => date('Y-m-d H:i:s')
    ];

    // Calculate derived fields
    if ($data['F_RECEPCION'] && $data['F_EMISION']) {
        $date1 = new DateTime($data['F_EMISION']);
        $date2 = new DateTime($data['F_RECEPCION']);
        $data['PLAZO_DE_ATENCION'] = $date2->diff($date1)->days;
        $data['SEMAFORO_DE_COLORES'] = calculateSemaforo($data['PLAZO_DE_ATENCION']);
    }

    try {
        $pdo->beginTransaction();
        
        $sql = "UPDATE detalle_requerimientos SET ";
        $params = [];
        foreach ($data as $field => $value) {
            $sql .= "$field = :$field, ";
            $params[":$field"] = $value;
        }
        $sql = rtrim($sql, ', ') . " WHERE id = :id";
        $params[':id'] = $id;

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        $pdo->commit();
        
        $_SESSION['success'] = "Seguimiento actualizado correctamente";
        header("Location: Views/administrador/panel/seguimientoarea.php?id=" . $requerimiento_id);
        exit();
    } catch (PDOException $e) {
        $pdo->rollBack();
         $_SESSION['error'] = "Error al actualizar: " . $e->getMessage();
        header("Location: Views/administrador/panel/seguimientoarea.php?id=" . $requerimiento_id);
         exit();
    }

  /*  header("Location: seguimientoarea.php?id=" . $requerimiento_id);
    exit(); */
}

function calculateSemaforo($days) {
    if ($days <= -1) return "NO PERMITIDO";
    if ($days <= 1) return "VERDE";
    if ($days == 2) return "AMARILLO";
    if ($days <= 4) return "ROJO";
    if ($days >= 5) return "NEGRO";
    return "NO RECEPCIONADO";
}


?>