<?php
require '../../../db.php';// Ajusta la ruta a tu archivo db.php

// Verificar si se recibió el ID por GET
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM requerimientos WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $requerimiento = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$requerimiento) {
            // Si no se encuentra el requerimiento, puedes mostrar un mensaje de error y salir
            echo "Requerimiento no encontrado.";
            exit();
        }
    } catch (PDOException $e) {
        echo "Error al obtener el requerimiento: " . $e->getMessage();
        exit();
    }
} else {
    // Si no se proporciona un ID válido, puedes mostrar un mensaje de error y salir
    echo "ID de requerimiento no válido.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Requerimiento</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="max-w-screen-2xl mx-auto my-8 px-4">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-[#2e5382]">Editar Requerimiento</h1>
            <div class="w-1/4 mx-auto h-0.5 bg-[#facc15]"></div>
        </div>

        <form action="../../../update_requerimiento.php" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <input type="hidden" name="id" value="<?php echo $requerimiento['id']; ?>">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="ITEM">ITEM</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="ITEM" name="ITEM" type="text" value="<?php echo htmlspecialchars($requerimiento['ITEM']); ?>" required>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="N_EMISION">N_EMISION</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="N_EMISION" name="N_EMISION" type="number" value="<?php echo htmlspecialchars($requerimiento['N_EMISION']); ?>">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="B_S_O">B_S_O</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="B_S_O" name="B_S_O" type="text" maxlength="1" value="<?php echo htmlspecialchars($requerimiento['B_S_O']); ?>">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="TIPO_DOC">TIPO_DOC</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="TIPO_DOC" name="TIPO_DOC" type="text" value="<?php echo htmlspecialchars($requerimiento['TIPO_DOC']); ?>">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="N_DOCUMENTO">N_DOCUMENTO</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="N_DOCUMENTO" name="N_DOCUMENTO" type="number" value="<?php echo htmlspecialchars($requerimiento['N_DOCUMENTO']); ?>">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="AREA_USUARIA">AREA_USUARIA</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="AREA_USUARIA" name="AREA_USUARIA" type="text" value="<?php echo htmlspecialchars($requerimiento['AREA_USUARIA']); ?>">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="F_EMISION">F_EMISION</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="F_EMISION" name="F_EMISION" type="date" value="<?php echo htmlspecialchars(explode(' ', $requerimiento['F_EMISION'])[0]); ?>">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="AREA_RECEPTORA">AREA_RECEPTORA</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="AREA_RECEPTORA" name="AREA_RECEPTORA" type="text" value="<?php echo htmlspecialchars($requerimiento['AREA_RECEPTORA']); ?>">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="F_RECEPCION">F_RECEPCION</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="F_RECEPCION" name="F_RECEPCION" type="date" value="<?php echo htmlspecialchars(explode(' ', $requerimiento['F_RECEPCION'])[0]); ?>">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="SINTESIS_DEL_ASUNTO">SINTESIS_DEL_ASUNTO</label>
                    <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="SINTESIS_DEL_ASUNTO" name="SINTESIS_DEL_ASUNTO" rows="3"><?php echo htmlspecialchars($requerimiento['SINTESIS_DEL_ASUNTO']); ?></textarea>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="MONTO_HOJA_SIGA">MONTO_HOJA_SIGA</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="MONTO_HOJA_SIGA" name="MONTO_HOJA_SIGA" type="number" step="0.01" value="<?php echo htmlspecialchars($requerimiento['MONTO_HOJA_SIGA']); ?>">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="MONTO_CP">MONTO_CP</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="MONTO_CP" name="MONTO_CP" type="number" step="0.01" value="<?php echo htmlspecialchars($requerimiento['MONTO_CP']); ?>">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="MONTO_CONTRATO">MONTO_CONTRATO</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="MONTO_CONTRATO" name="MONTO_CONTRATO" type="number" step="0.01" value="<?php echo htmlspecialchars($requerimiento['MONTO_CONTRATO']); ?>">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="CONTRATO">CONTRATO</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="CONTRATO" name="CONTRATO" type="text" value="<?php echo htmlspecialchars($requerimiento['CONTRATO']); ?>">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="ENTREGABLES">ENTREGABLES</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="ENTREGABLES" name="ENTREGABLES" type="number" value="<?php echo htmlspecialchars($requerimiento['ENTREGABLES']); ?>">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="PAGOS_ACUMULADO">PAGOS_ACUMULADO</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="PAGOS_ACUMULADO" name="PAGOS_ACUMULADO" type="number" value="<?php echo htmlspecialchars($requerimiento['PAGOS_ACUMULADO']); ?>">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="ESTADO">ESTADO</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="ESTADO" name="ESTADO" type="text" value="<?php echo htmlspecialchars($requerimiento['ESTADO']); ?>">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="OEPS">OEPS</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="OEPS" name="OEPS" type="text" value="<?php echo htmlspecialchars($requerimiento['OEPS']); ?>">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="PROCESO">PROCESO</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="PROCESO" name="PROCESO" type="text" value="<?php echo htmlspecialchars($requerimiento['PROCESO']); ?>">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="INDAGACION_MERCADO">INDAGACION_MERCADO</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="INDAGACION_MERCADO" name="INDAGACION_MERCADO" type="text" value="<?php echo htmlspecialchars($requerimiento['INDAGACION_MERCADO']); ?>">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="CONFORMACION_EXP_CONTRATACION">CONFORMACION_EXP_CONTRATACION</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="CONFORMACION_EXP_CONTRATACION" name="CONFORMACION_EXP_CONTRATACION" type="text" value="<?php echo htmlspecialchars($requerimiento['CONFORMACION_EXP_CONTRATACION']); ?>">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="APROBACION_BASES">APROBACION_BASES</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="APROBACION_BASES" name="APROBACION_BASES" type="datetime-local" value="<?php echo htmlspecialchars(str_replace(' ', 'T', $requerimiento['APROBACION_BASES'])); ?>">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="CONVOCATORIA">CONVOCATORIA</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="CONVOCATORIA" name="CONVOCATORIA" type="date" value="<?php echo htmlspecialchars(explode(' ', $requerimiento['CONVOCATORIA'])[0]); ?>">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="REGISTRO_PARTICIPANTES">REGISTRO_PARTICIPANTES</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="REGISTRO_PARTICIPANTES" name="REGISTRO_PARTICIPANTES" type="date" value="<?php echo htmlspecialchars(explode(' ', $requerimiento['REGISTRO_PARTICIPANTES'])[0]); ?>">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="CONSULTAS_OBSERVACIONES">CONSULTAS_OBSERVACIONES</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="CONSULTAS_OBSERVACIONES" name="CONSULTAS_OBSERVACIONES" type="date" value="<?php echo htmlspecialchars(explode(' ', $requerimiento['CONSULTAS_OBSERVACIONES'])[0]); ?>">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="INTEGRACION_BASES">INTEGRACION_BASES</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="INTEGRACION_BASES" name="INTEGRACION_BASES" type="date" value="<?php echo htmlspecialchars(explode(' ', $requerimiento['INTEGRACION_BASES'])[0]); ?>">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="PRESENTACION_OFERTAS">PRESENTACION_OFERTAS</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="PRESENTACION_OFERTAS" name="PRESENTACION_OFERTAS" type="date" value="<?php echo htmlspecialchars(explode(' ', $requerimiento['PRESENTACION_OFERTAS'])[0]); ?>">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="EVALUACION_CALIFICACION">EVALUACION_CALIFICACION</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="EVALUACION_CALIFICACION" name="EVALUACION_CALIFICACION" type="date" value="<?php echo htmlspecialchars(explode(' ', $requerimiento['EVALUACION_CALIFICACION'])[0]); ?>">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="BUENA_PRO">BUENA_PRO</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="BUENA_PRO" name="BUENA_PRO" type="date" value="<?php echo htmlspecialchars(explode(' ', $requerimiento['BUENA_PRO'])[0]); ?>">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="PRESENTACION_DOCS_PARA_CONTRATO">PRESENTACION_DOCS_PARA_CONTRATO</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="PRESENTACION_DOCS_PARA_CONTRATO" name="PRESENTACION_DOCS_PARA_CONTRATO" type="date" value="<?php echo htmlspecialchars(explode(' ', $requerimiento['PRESENTACION_DOCS_PARA_CONTRATO'])[0]); ?>">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="F_FIRMA_CONTRATO">F_FIRMA_CONTRATO</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="F_FIRMA_CONTRATO" name="F_FIRMA_CONTRATO" type="date" value="<?php echo htmlspecialchars(explode(' ', $requerimiento['F_FIRMA_CONTRATO'])[0]); ?>">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="RESULTADO">RESULTADO</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="RESULTADO" name="RESULTADO" type="text" value="<?php echo htmlspecialchars($requerimiento['RESULTADO']); ?>">
                </div>
            </div>

            <div class="flex items-center justify-between mt-6">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Actualizar
                </button>
                <a href="../panel/showpanel.php" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</body>
</html>