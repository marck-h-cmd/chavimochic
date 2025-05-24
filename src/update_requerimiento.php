<?php
require 'db.php'; // Ajusta la ruta a tu archivo db.php

function emptyToNull($value) {
    return empty($value) ? null : $value;
}

date_default_timezone_set('America/Lima');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar si se recibió el ID del requerimiento
    if (isset($_POST['id']) && is_numeric($_POST['id'])) {
        $id = $_POST['id'];

        // Recoger los demás datos del formulario
        $ITEM = $_POST['ITEM'] ?? '';
        $N_EMISION = emptyToNull($_POST['N_EMISION']);
        $B_S_O = emptyToNull($_POST['B_S_O']);
        $TIPO_DOC = emptyToNull($_POST['TIPO_DOC']);
        $N_DOCUMENTO = emptyToNull($_POST['N_DOCUMENTO']);
        $AREA_USUARIA = emptyToNull($_POST['AREA_USUARIA']);
        $F_EMISION = emptyToNull($_POST['F_EMISION']);
        $AREA_RECEPTORA = emptyToNull($_POST['AREA_RECEPTORA']);
        $F_RECEPCION = emptyToNull($_POST['F_RECEPCION']);
        $SINTESIS_DEL_ASUNTO = emptyToNull($_POST['SINTESIS_DEL_ASUNTO']);
        $MONTO_HOJA_SIGA = emptyToNull($_POST['MONTO_HOJA_SIGA']);
        $MONTO_CP = emptyToNull($_POST['MONTO_CP']);
        $MONTO_CONTRATO = emptyToNull($_POST['MONTO_CONTRATO']);
        $CONTRATO = emptyToNull($_POST['CONTRATO']);
        $ENTREGABLES = emptyToNull($_POST['ENTREGABLES']);
        $PAGOS_ACUMULADO = emptyToNull($_POST['PAGOS_ACUMULADO']);
        $ESTADO = emptyToNull($_POST['ESTADO']);
        $OEPS = emptyToNull($_POST['OEPS']);
        $PROCESO = emptyToNull($_POST['PROCESO']);
        $INDAGACION_MERCADO = emptyToNull($_POST['INDAGACION_MERCADO']);
        $CONFORMACION_EXP_CONTRATACION = emptyToNull($_POST['CONFORMACION_EXP_CONTRATACION']);
        $APROBACION_BASES = emptyToNull($_POST['APROBACION_BASES']);
        $CONVOCATORIA = emptyToNull($_POST['CONVOCATORIA']);
        $REGISTRO_PARTICIPANTES = emptyToNull($_POST['REGISTRO_PARTICIPANTES']);
        $CONSULTAS_OBSERVACIONES = emptyToNull($_POST['CONSULTAS_OBSERVACIONES']);
        $INTEGRACION_BASES = emptyToNull($_POST['INTEGRACION_BASES']);
        $PRESENTACION_OFERTAS = emptyToNull($_POST['PRESENTACION_OFERTAS']);
        $EVALUACION_CALIFICACION = emptyToNull($_POST['EVALUACION_CALIFICACION']);
        $BUENA_PRO = emptyToNull($_POST['BUENA_PRO']);
        $PRESENTACION_DOCS_PARA_CONTRATO = emptyToNull($_POST['PRESENTACION_DOCS_PARA_CONTRATO']);
        $F_FIRMA_CONTRATO = emptyToNull($_POST['F_FIRMA_CONTRATO']);
        $RESULTADO = emptyToNull($_POST['RESULTADO']);
        $F_EDICION = date('Y-m-d H:i:s'); // Fecha y hora actual

        // Calcular campos derivados
        $DEVENGADO_ACUMULADO = (is_numeric($MONTO_CONTRATO) && is_numeric($ENTREGABLES) && is_numeric($PAGOS_ACUMULADO) && $ENTREGABLES != 0) ? ($MONTO_CONTRATO / $ENTREGABLES) * $PAGOS_ACUMULADO : null;
        $EJECUCION_CONTRACTUAL = (is_numeric($PAGOS_ACUMULADO) && is_numeric($ENTREGABLES) && $ENTREGABLES != 0) ? $PAGOS_ACUMULADO / $ENTREGABLES : null;

        // Calcular PLAZO_DE_ATENCION
        $PLAZO_DE_ATENCION = null;
        if ($F_RECEPCION && $F_EMISION) {
            $fecha_recepcion = new DateTime($F_RECEPCION);
            $fecha_emision = new DateTime($F_EMISION);
            $intervalo = $fecha_recepcion->diff($fecha_emision);
            $PLAZO_DE_ATENCION = $intervalo->days;
        }

        // Calcular SEMAFORO_DE_COLORES
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
            $stmt = $pdo->prepare("UPDATE requerimientos SET
                ITEM = :ITEM,
                N_EMISION = :N_EMISION,
                B_S_O = :B_S_O,
                TIPO_DOC = :TIPO_DOC,
                N_DOCUMENTO = :N_DOCUMENTO,
                AREA_USUARIA = :AREA_USUARIA,
                F_EMISION = :F_EMISION,
                AREA_RECEPTORA = :AREA_RECEPTORA,
                F_RECEPCION = :F_RECEPCION,
                SINTESIS_DEL_ASUNTO = :SINTESIS_DEL_ASUNTO,
                MONTO_HOJA_SIGA = :MONTO_HOJA_SIGA,
                MONTO_CP = :MONTO_CP,
                MONTO_CONTRATO = :MONTO_CONTRATO,
                CONTRATO = :CONTRATO,
                ENTREGABLES = :ENTREGABLES,
                PAGOS_ACUMULADO = :PAGOS_ACUMULADO,
                ESTADO = :ESTADO,
                OEPS = :OEPS,
                PROCESO = :PROCESO,
                INDAGACION_MERCADO = :INDAGACION_MERCADO,
                CONFORMACION_EXP_CONTRATACION = :CONFORMACION_EXP_CONTRATACION,
                APROBACION_BASES = :APROBACION_BASES,
                CONVOCATORIA = :CONVOCATORIA,
                REGISTRO_PARTICIPANTES = :REGISTRO_PARTICIPANTES,
                CONSULTAS_OBSERVACIONES = :CONSULTAS_OBSERVACIONES,
                INTEGRACION_BASES = :INTEGRACION_BASES,
                PRESENTACION_OFERTAS = :PRESENTACION_OFERTAS,
                EVALUACION_CALIFICACION = :EVALUACION_CALIFICACION,
                BUENA_PRO = :BUENA_PRO,
                PRESENTACION_DOCS_PARA_CONTRATO = :PRESENTACION_DOCS_PARA_CONTRATO,
                F_FIRMA_CONTRATO = :F_FIRMA_CONTRATO,
                RESULTADO = :RESULTADO,
                DEVENGADO_ACUMULADO = :DEVENGADO_ACUMULADO,
                EJECUCION_CONTRACTUAL = :EJECUCION_CONTRACTUAL,
                PLAZO_DE_ATENCION = :PLAZO_DE_ATENCION,
                SEMAFORO_DE_COLORES = :SEMAFORO_DE_COLORES,
                F_EDICION = :F_EDICION
                WHERE id = :id");

            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':ITEM', $ITEM);
            $stmt->bindParam(':N_EMISION', $N_EMISION, PDO::PARAM_INT);
            $stmt->bindParam(':B_S_O', $B_S_O);
            $stmt->bindParam(':TIPO_DOC', $TIPO_DOC);
            $stmt->bindParam(':N_DOCUMENTO', $N_DOCUMENTO, PDO::PARAM_INT);
            $stmt->bindParam(':AREA_USUARIA', $AREA_USUARIA);
            $stmt->bindParam(':F_EMISION', $F_EMISION);
            $stmt->bindParam(':AREA_RECEPTORA', $AREA_RECEPTORA);
            $stmt->bindParam(':F_RECEPCION', $F_RECEPCION);
            $stmt->bindParam(':SINTESIS_DEL_ASUNTO', $SINTESIS_DEL_ASUNTO);
            $stmt->bindParam(':MONTO_HOJA_SIGA', $MONTO_HOJA_SIGA, PDO::PARAM_STR);
            $stmt->bindParam(':MONTO_CP', $MONTO_CP, PDO::PARAM_STR);
            $stmt->bindParam(':MONTO_CONTRATO', $MONTO_CONTRATO, PDO::PARAM_STR);
            $stmt->bindParam(':CONTRATO', $CONTRATO);
            $stmt->bindParam(':ENTREGABLES', $ENTREGABLES, PDO::PARAM_INT);
            $stmt->bindParam(':PAGOS_ACUMULADO', $PAGOS_ACUMULADO, PDO::PARAM_STR);
            $stmt->bindParam(':ESTADO', $ESTADO);
            $stmt->bindParam(':OEPS', $OEPS);
            $stmt->bindParam(':PROCESO', $PROCESO);
            $stmt->bindParam(':INDAGACION_MERCADO', $INDAGACION_MERCADO);
            $stmt->bindParam(':CONFORMACION_EXP_CONTRATACION', $CONFORMACION_EXP_CONTRATACION);
            $stmt->bindParam(':APROBACION_BASES', $APROBACION_BASES);
            $stmt->bindParam(':CONVOCATORIA', $CONVOCATORIA);
            $stmt->bindParam(':REGISTRO_PARTICIPANTES', $REGISTRO_PARTICIPANTES);
            $stmt->bindParam(':CONSULTAS_OBSERVACIONES', $CONSULTAS_OBSERVACIONES);
            $stmt->bindParam(':INTEGRACION_BASES', $INTEGRACION_BASES);
            $stmt->bindParam(':PRESENTACION_OFERTAS', $PRESENTACION_OFERTAS);
            $stmt->bindParam(':EVALUACION_CALIFICACION', $EVALUACION_CALIFICACION);
            $stmt->bindParam(':BUENA_PRO', $BUENA_PRO);
            $stmt->bindParam(':PRESENTACION_DOCS_PARA_CONTRATO', $PRESENTACION_DOCS_PARA_CONTRATO);
            $stmt->bindParam(':F_FIRMA_CONTRATO', $F_FIRMA_CONTRATO);
            $stmt->bindParam(':RESULTADO', $RESULTADO);
            $stmt->bindParam(':DEVENGADO_ACUMULADO', $DEVENGADO_ACUMULADO, PDO::PARAM_STR);
            $stmt->bindParam(':EJECUCION_CONTRACTUAL', $EJECUCION_CONTRACTUAL, PDO::PARAM_STR);
            $stmt->bindParam(':PLAZO_DE_ATENCION', $PLAZO_DE_ATENCION, PDO::PARAM_INT);
            $stmt->bindParam(':SEMAFORO_DE_COLORES', $SEMAFORO_DE_COLORES);
            $stmt->bindParam(':F_EDICION', $F_EDICION);

            if ($stmt->execute()) {
                // Redirigir de vuelta a showpanel.php con un mensaje de éxito
                header('Location: Views/administrador/panel/showpanel.php?edit=success');
                exit();
            } else {
                // Redirigir con un mensaje de error
                header('Location: Views/administrador/panel/showpanel.php?edit=error');
                exit();
            }

        } catch (PDOException $e) {
            // Mostrar un mensaje de error más detallado
            die("Error al actualizar el requerimiento: " . $e->getMessage());
        }
    } else {
        echo "ID de requerimiento no válido.";
    }
} else {
    // Si se intenta acceder a este script por GET
    header('HTTP/1.1 405 Method Not Allowed');
    echo "Método no permitido.";
}
?>