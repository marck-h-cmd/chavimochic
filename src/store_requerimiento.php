<?php
// filepath: c:\xampp\htdocs\chavimochic\src\store_requerimiento.php
// src/store_requerimiento.php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir y validar los datos del formulario
    $item = $_POST['ITEM'] ?? '';
    $n_emision = $_POST['N_EMISION'] ?? null;
    $b_s_o = $_POST['B_S_O'] ?? null;
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

    $monto_hoja_siga = $_POST['MONTO_HOJA_SIGA'] ?? null;
    $monto_cp = $_POST['MONTO_CP'] ?? null;
    $monto_contrato = $_POST['MONTO_CONTRATO'] ?? null;
    $contrato = $_POST['CONTRATO'] ?? null;
    $entregables = $_POST['ENTREGABLES'] ?? null;
    $pagos_acumulado = $_POST['PAGOS_ACUMULADO'] ?? null;

    // Calcular DEVENGADO_ACUMULADO si MONTO_CONTRATO y ENTREGABLES son válidos
    $devengado_acumulado = null;
    if ($monto_contrato !== null && $entregables !== null && $entregables > 0 && $pagos_acumulado !== null) {
        $devengado_acumulado = ($monto_contrato / $entregables) * $pagos_acumulado;
    }

    // Calcular EJECUCION_CONTRACTUAL si ENTREGABLES es válido y mayor que cero
    $ejecucion_contractual = null;
    if ($entregables !== null && $entregables > 0 && $pagos_acumulado !== null) {
        $ejecucion_contractual = $pagos_acumulado / $entregables;
    }

    $estado = $_POST['ESTADO'] ?? null;
    $oeps = $_POST['OEPS'] ?? null;
    $proceso = $_POST['PROCESO'] ?? null;
    $indagacion_mercado = $_POST['INDAGACION_MERCADO'] ?? null;
    $conformacion_exp_contratacion = $_POST['CONFORMACION_EXP_CONTRATACION'] ?? null;
    $aprobacion_bases = $_POST['APROBACION_BASES'] ?? null;
    $convocatoria = $_POST['CONVOCATORIA'] ?? null;
    $registro_participantes = $_POST['REGISTRO_PARTICIPANTES'] ?? null;
    $consultas_observaciones = $_POST['CONSULTAS_OBSERVACIONES'] ?? null;
    $integracion_bases = $_POST['INTEGRACION_BASES'] ?? null;
    $presentacion_ofertas = $_POST['PRESENTACION_OFERTAS'] ?? null;
    $evaluacion_calificacion = $_POST['EVALUACION_CALIFICACION'] ?? null;
    $buena_pro = $_POST['BUENA_PRO'] ?? null;
    $presentacion_docs_para_contrato = $_POST['PRESENTACION_DOCS_PARA_CONTRATO'] ?? null;
    $f_firma_contrato = $_POST['F_FIRMA_CONTRATO'] ?? null;
    $resultado = $_POST['RESULTADO'] ?? '';

    $stmt = $pdo->prepare("INSERT INTO requerimientos (
        ITEM, N_EMISION, B_S_O, TIPO_DOC, N_DOCUMENTO, AREA_USUARIA, F_EMISION, AREA_RECEPTORA, F_RECEPCION,
        SINTESIS_DEL_ASUNTO, PLAZO_DE_ATENCION, SEMAFORO_DE_COLORES, MONTO_HOJA_SIGA, MONTO_CP, MONTO_CONTRATO,
        CONTRATO, ENTREGABLES, PAGOS_ACUMULADO, DEVENGADO_ACUMULADO, EJECUCION_CONTRACTUAL, ESTADO, OEPS, PROCESO,
        INDAGACION_MERCADO, CONFORMACION_EXP_CONTRATACION, APROBACION_BASES, CONVOCATORIA, REGISTRO_PARTICIPANTES,
        CONSULTAS_OBSERVACIONES, INTEGRACION_BASES, PRESENTACION_OFERTAS, EVALUACION_CALIFICACION, BUENA_PRO,
        PRESENTACION_DOCS_PARA_CONTRATO, F_FIRMA_CONTRATO, RESULTADO
    ) VALUES (
        :ITEM, :N_EMISION, :B_S_O, :TIPO_DOC, :N_DOCUMENTO, :AREA_USUARIA, :F_EMISION, :AREA_RECEPTORA, :F_RECEPCION,
        :SINTESIS_DEL_ASUNTO, :PLAZO_DE_ATENCION, :SEMAFORO_DE_COLORES, :MONTO_HOJA_SIGA, :MONTO_CP, :MONTO_CONTRATO,
        :CONTRATO, :ENTREGABLES, :PAGOS_ACUMULADO, :DEVENGADO_ACUMULADO, :EJECUCION_CONTRACTUAL, :ESTADO, :OEPS, :PROCESO,
        :INDAGACION_MERCADO, :CONFORMACION_EXP_CONTRATACION, :APROBACION_BASES, :CONVOCATORIA, :REGISTRO_PARTICIPANTES,
        :CONSULTAS_OBSERVACIONES, :INTEGRACION_BASES, :PRESENTACION_OFERTAS, :EVALUACION_CALIFICACION, :BUENA_PRO,
        :PRESENTACION_DOCS_PARA_CONTRATO, :F_FIRMA_CONTRATO, :RESULTADO
    )");

    $stmt->bindParam(':ITEM', $item);
    $stmt->bindParam(':N_EMISION', $n_emision, PDO::PARAM_INT);
    $stmt->bindParam(':B_S_O', $b_s_o);
    $stmt->bindParam(':TIPO_DOC', $tipo_doc);
    $stmt->bindParam(':N_DOCUMENTO', $n_documento, PDO::PARAM_INT);
    $stmt->bindParam(':AREA_USUARIA', $area_usuaria);
    $stmt->bindParam(':F_EMISION', $f_emision);
    $stmt->bindParam(':AREA_RECEPTORA', $area_receptora);
    $stmt->bindParam(':F_RECEPCION', $f_recepcion);
    $stmt->bindParam(':SINTESIS_DEL_ASUNTO', $sintesis_del_asunto);
    $stmt->bindParam(':PLAZO_DE_ATENCION', $plazo_de_atencion, PDO::PARAM_INT);
    $stmt->bindParam(':SEMAFORO_DE_COLORES', $semaforo_de_colores);
    $stmt->bindParam(':MONTO_HOJA_SIGA', $monto_hoja_siga);
    $stmt->bindParam(':MONTO_CP', $monto_cp);
    $stmt->bindParam(':MONTO_CONTRATO', $monto_contrato);
    $stmt->bindParam(':CONTRATO', $contrato);
    $stmt->bindParam(':ENTREGABLES', $entregables, PDO::PARAM_INT);
    $stmt->bindParam(':PAGOS_ACUMULADO', $pagos_acumulado, PDO::PARAM_INT);
    $stmt->bindParam(':DEVENGADO_ACUMULADO', $devengado_acumulado);
    $stmt->bindParam(':EJECUCION_CONTRACTUAL', $ejecucion_contractual);
    $stmt->bindParam(':ESTADO', $estado);
    $stmt->bindParam(':OEPS', $oeps);
    $stmt->bindParam(':PROCESO', $proceso);
    $stmt->bindParam(':INDAGACION_MERCADO', $indagacion_mercado);
    $stmt->bindParam(':CONFORMACION_EXP_CONTRATACION', $conformacion_exp_contratacion);
    $stmt->bindParam(':APROBACION_BASES', $aprobacion_bases);
    $stmt->bindParam(':CONVOCATORIA', $convocatoria);
    $stmt->bindParam(':REGISTRO_PARTICIPANTES', $registro_participantes);
    $stmt->bindParam(':CONSULTAS_OBSERVACIONES', $consultas_observaciones);
    $stmt->bindParam(':INTEGRACION_BASES', $integracion_bases);
    $stmt->bindParam(':PRESENTACION_OFERTAS', $presentacion_ofertas);
    $stmt->bindParam(':EVALUACION_CALIFICACION', $evaluacion_calificacion);
    $stmt->bindParam(':BUENA_PRO', $buena_pro);
    $stmt->bindParam(':PRESENTACION_DOCS_PARA_CONTRATO', $presentacion_docs_para_contrato);
    $stmt->bindParam(':F_FIRMA_CONTRATO', $f_firma_contrato);
    $stmt->bindParam(':RESULTADO', $resultado);

    if ($stmt->execute()) {
        // Redireccionar o mostrar un mensaje de éxito
        header('Location: /chavimochic/src/Views/administrador/panel/showpanel.php?store=success'); // Crea una página success.php
        exit();
    } else {
        // Mostrar un mensaje de error
        echo "Error al guardar el requerimiento.";
        error_log("Error al insertar requerimiento: " . print_r($stmt->errorInfo(), true));
    }
} else {
    // Si la solicitud no es POST, podrías redirigir o mostrar un formulario
    echo "No se recibieron datos del formulario.";
}
?>