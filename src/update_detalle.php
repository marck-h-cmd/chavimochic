<?php
require 'db.php'; 

function emptyToNull($value) {
    return empty($value) ? null : $value;
}

date_default_timezone_set('America/Lima');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if (isset($_POST['id']) && is_numeric($_POST['id'])) {
        $id = $_POST['id'];
        $requerimiento_id = $_POST['REQUERIMIENTO_ID'] ?? null;

      
        $TIPO_DOC = $_POST['E_TIPO_DOC'] ?? '';
        $N_DOCUMENTO = emptyToNull($_POST['E_N_DOCUMENTO']);
        $AREA_USUARIA = emptyToNull($_POST['E_AREA_USUARIA']);
        $F_EMISION = emptyToNull($_POST['E_F_EMISION']);
        $AREA_RECEPTORA = emptyToNull($_POST['E_AREA_RECEPTORA']);
        $F_RECEPCION = emptyToNull($_POST['E_F_RECEPCION']);
        $SINTESIS_DEL_ASUNTO = emptyToNull($_POST['E_SINTESIS_DEL_ASUNTO']);
        $F_EDICION = date('Y-m-d H:i:s'); 

        
        $PLAZO_DE_ATENCION = null;
        if ($F_RECEPCION && $F_EMISION) {
            $fecha_recepcion = new DateTime($F_RECEPCION);
            $fecha_emision = new DateTime($F_EMISION);
            $intervalo = $fecha_recepcion->diff($fecha_emision);
            $PLAZO_DE_ATENCION = $intervalo->days;
        }

        
        $SEMAFORO_DE_COLORES = null;
        if ($PLAZO_DE_ATENCION === null) {
            $SEMAFORO_DE_COLORES = "NO RECEPCIONADO";
        } elseif ($PLAZO_DE_ATENCION <= -1) {
            $SEMAFORO_DE_COLORES = "NO PERMITIDO";
        } elseif ($PLAZO_DE_ATENCION <= 1) {
            $SEMAFORO_DE_COLORES = "VERDE";
        } elseif ($PLAZO_DE_ATENCION == 2) {
            $SEMAFORO_DE_COLORES = "AMARILLO";
        } elseif ($PLAZO_DE_ATENCION <= 4) {
            $SEMAFORO_DE_COLORES = "ROJO";
        } elseif ($PLAZO_DE_ATENCION >= 5) {
            $SEMAFORO_DE_COLORES = "NEGRO";
        }

        try {
            $stmt = $pdo->prepare("UPDATE detalle_requerimientos SET
                TIPO_DOC = :TIPO_DOC,
                N_DOCUMENTO = :N_DOCUMENTO,
                AREA_USUARIA = :AREA_USUARIA,
                F_EMISION = :F_EMISION,
                AREA_RECEPTORA = :AREA_RECEPTORA,
                F_RECEPCION = :F_RECEPCION,
                SINTESIS_DEL_ASUNTO = :SINTESIS_DEL_ASUNTO,
                PLAZO_DE_ATENCION = :PLAZO_DE_ATENCION,
                SEMAFORO_DE_COLORES = :SEMAFORO_DE_COLORES,
                F_EDICION = :F_EDICION
                WHERE id = :id");

            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':TIPO_DOC', $TIPO_DOC);
            $stmt->bindParam(':N_DOCUMENTO', $N_DOCUMENTO, PDO::PARAM_INT);
            $stmt->bindParam(':AREA_USUARIA', $AREA_USUARIA);
            $stmt->bindParam(':F_EMISION', $F_EMISION);
            $stmt->bindParam(':AREA_RECEPTORA', $AREA_RECEPTORA);
            $stmt->bindParam(':F_RECEPCION', $F_RECEPCION);
            $stmt->bindParam(':SINTESIS_DEL_ASUNTO', $SINTESIS_DEL_ASUNTO);
            $stmt->bindParam(':PLAZO_DE_ATENCION', $PLAZO_DE_ATENCION, PDO::PARAM_INT);
            $stmt->bindParam(':SEMAFORO_DE_COLORES', $SEMAFORO_DE_COLORES);
            $stmt->bindParam(':F_EDICION', $F_EDICION);

            if ($stmt->execute()) {
                // Start session if not already started
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                
                // Set success message in session
                $_SESSION['success'] = "El seguimiento se ha actualizado correctamente.";
                
                // Redirect back to the same page with the requerimiento_id
                header("Location: /chavimochic/src/Views/administrador/panel/seguimientoarea.php?id=" . urlencode($requerimiento_id));
                exit();
            } else {
                // Redirect with error message
                 $_SESSION['error'] = "Hubo un error.";
                header("Location: /chavimochic/src/Views/administrador/panel/seguimientoarea.php?id=" . urlencode($requerimiento_id));
                exit();
            }

        } catch (PDOException $e) {
            // Log detailed error
            error_log("Error updating detalle_requerimiento: " . $e->getMessage());
            
            // Redirect with error message
            if (isset($requerimiento_id)) {
                header("Location: /chavimochic/src/Views/administrador/panel/seguimientoarea.php?id=" . urlencode($requerimiento_id));
            } else {
                header("Location: /chavimochic/src/Views/administrador/panel/seguimientoarea.php?error=1");
            }
            exit();
        }
    } else {
        // Invalid ID case
        header("Location: /chavimochic/src/Views/administrador/panel/seguimientoarea.php?error=invalid_id");
        exit();
    }
} else {
    // If trying to access this script via GET
    header('HTTP/1.1 405 Method Not Allowed');
    echo "Método no permitido.";
    exit();
}
?>