<?php
// filepath: c:\xampp\htdocs\chavimochic\src\store_requerimiento.php
// src/store_detalles_requerimiento.php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Validar si existe foreign key
    $requerimiento_id = $_POST['REQUERIMIENTO_ID'] ?? null;

    if (!$requerimiento_id) {
        die("Error: REQUERIMIENTO_ID is required");
    }

    $stmt = $pdo->prepare("SELECT id FROM requerimientos WHERE id = ?");
    $stmt->execute([$requerimiento_id]);
    if (!$stmt->fetch()) {
        die("Error: Invalid REQUERIMIENTO_ID");
    }
    // Recibir y validar los datos del formulario
    $requerimiento_id = $_POST['REQUERIMIENTO_ID'] ?? '';
    $tipo_doc = $_POST['TIPO_DOC'] ?? null;
    $n_documento = $_POST['N_DOCUMENTO'] ?? null;
    $area_usuaria = $_POST['AREA_USUARIA'] ?? null;
    $f_emision = $_POST['F_EMISION'] ?? null;
    $area_receptora = $_POST['AREA_RECEPTORA'] ?? null;
    $f_recepcion = $_POST['F_RECEPCION'] ?? null;
    $sintesis_del_asunto = $_POST['SINTESIS_DEL_ASUNTO'] ?? null;

    // Calcular PLAZO_DE_ATENCION si F_EMISION y F_RECEPCION están definidas
    $plazo_de_atencion = null;
    if ($f_recepcion && $f_emision) {
        $date1 = new DateTime($f_emision);
        $date2 = new DateTime($f_recepcion);
        $interval = $date1->diff($date2);
        $plazo_de_atencion = $interval->days;
    }

    // Calcular SEMAFORO_DE_COLORES basado en PLAZO_DE_ATENCION
    $semaforo_de_colores = 'NO RECEPCIONADO';
    if ($plazo_de_atencion !== null) {
        if ($plazo_de_atencion <= -1) {
            $semaforo_de_colores = 'NO PERMITIDO';
        } elseif ($plazo_de_atencion <= 1) {
            $semaforo_de_colores = 'VERDE';
        } elseif ($plazo_de_atencion == 2) {
            $semaforo_de_colores = 'AMARILLO';
        } elseif ($plazo_de_atencion <= 4) {
            $semaforo_de_colores = 'ROJO';
        } elseif ($plazo_de_atencion >= 5) {
            $semaforo_de_colores = 'NEGRO';
        }
    }


    $stmt = $pdo->prepare("INSERT INTO detalle_requerimientos (
            REQUERIMIENTO_ID, TIPO_DOC, N_DOCUMENTO, AREA_USUARIA, F_EMISION, 
            AREA_RECEPTORA, F_RECEPCION, SINTESIS_DEL_ASUNTO,
            PLAZO_DE_ATENCION, SEMAFORO_DE_COLORES
    ) VALUES (
         :REQUERIMIENTO_ID, :TIPO_DOC, :N_DOCUMENTO, :AREA_USUARIA, :F_EMISION, 
            :AREA_RECEPTORA, :F_RECEPCION, :SINTESIS_DEL_ASUNTO,
            :PLAZO_DE_ATENCION, :SEMAFORO_DE_COLORES
    )");

    $stmt->bindParam(':REQUERIMIENTO_ID', $requerimiento_id);
    $stmt->bindParam(':TIPO_DOC', $tipo_doc);
    $stmt->bindParam(':N_DOCUMENTO', $n_documento, PDO::PARAM_INT);
    $stmt->bindParam(':AREA_USUARIA', $area_usuaria);
    $stmt->bindParam(':F_EMISION', $f_emision);
    $stmt->bindParam(':AREA_RECEPTORA', $area_receptora);
    $stmt->bindParam(':F_RECEPCION', $f_recepcion);
    $stmt->bindParam(':SINTESIS_DEL_ASUNTO', $sintesis_del_asunto);
    $stmt->bindParam( ':PLAZO_DE_ATENCION', $plazo_de_atencion);
    $stmt->bindParam( ':SEMAFORO_DE_COLORES', $semaforo_de_colores);





    if ($stmt->execute()) {
          $_SESSION['success'] = "El detalle del requerimiento se ha creado correctamente.";
        //  $_SESSION['success'] = "Creado!";
        header("Location: /chavimochic/src/Views/administrador/panel/seguimientoarea.php?id=" . urlencode($_POST['REQUERIMIENTO_ID']));

        exit();
    } else {
        // Mostrar un mensaje de error
        echo "Error al guardar el requerimiento.";
        $_SESSION['error'] = "Hubo un error!";
        error_log("Error al insertar requerimiento: " . print_r($stmt->errorInfo(), true));
    }
} else {
    // Si la solicitud no es POST, podrías redirigir o mostrar un formulario
    echo "No se recibieron datos del formulario.";
}
?>