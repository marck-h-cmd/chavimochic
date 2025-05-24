<?php
require '../../../db.php';

// Verificar si se recibió el ID por GET
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM detalle_requerimientos WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $detalle = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$detalle) {
            // Si no se encuentra el requerimiento, puedes mostrar un mensaje de error y salir
            echo "Seguimiento no encontrado.";
            exit();
        }
    } catch (PDOException $e) {
        echo "Error al obtener el requerimiento: " . $e->getMessage();
        exit();
    }
} else {
    // Si no se proporciona un ID válido, puedes mostrar un mensaje de error y salir
    echo "ID de seguimiento no válido.";
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
            <h1 class="text-2xl font-bold text-[#2e5382]">Editar Seguimiento</h1>
            <div class="w-1/4 mx-auto h-0.5 bg-[#facc15]"></div>
        </div>

        <form action="../../../update_detalle.php" method="POST"
            class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <input type="hidden" name="id" value="<?= htmlspecialchars($detalle['id']) ?>">
           <input type="hidden" name="REQUERIMIENTO_ID" value="<?= htmlspecialchars($detalle['REQUERIMIENTO_ID']) ?>">


            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="TIPO_DOC">TIPO_DOC</label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="TIPO_DOC" name="E_TIPO_DOC" type="text"
                        value="<?= htmlspecialchars($detalle['TIPO_DOC']) ?>" required>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="N_DOCUMENTO">N_DOCUMENTO</label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="N_DOCUMENTO" name="E_N_DOCUMENTO" type="number"
                        value="<?= htmlspecialchars($detalle['N_DOCUMENTO']) ?>">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="AREA_USUARIA">AREA_USUARIA</label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="AREA_USUARIA" name="E_AREA_USUARIA" type="text"
                        value="<?= htmlspecialchars($detalle['AREA_USUARIA']) ?>">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="F_EMISION">F_EMISION</label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="F_EMISION" name="E_F_EMISION" type="date"
                        value="<?= htmlspecialchars(explode(' ', $detalle['F_EMISION'])[0]) ?>">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2"
                        for="AREA_RECEPTORA">AREA_RECEPTORA</label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="AREA_RECEPTORA" name="E_AREA_RECEPTORA" type="text"
                        value="<?= htmlspecialchars($detalle['AREA_RECEPTORA']) ?>">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="F_RECEPCION">F_RECEPCION</label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="F_RECEPCION" name="E_F_RECEPCION" type="date"
                        value="<?= htmlspecialchars(explode(' ', $detalle['F_RECEPCION'])[0]) ?>">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2"
                        for="SINTESIS_DEL_ASUNTO">SINTESIS_DEL_ASUNTO</label>
                    <textarea
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="SINTESIS_DEL_ASUNTO" name="E_SINTESIS_DEL_ASUNTO"
                        rows="3"><?= htmlspecialchars($detalle['SINTESIS_DEL_ASUNTO']) ?></textarea>
                </div>

            </div>

            <div class="flex items-center justify-between mt-6">
                <button
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    type="submit">
                    Actualizar
                </button>
                <a href="../panel/seguimientoarea.php?id=<?= urlencode($detalle['REQUERIMIENTO_ID']) ?>"
                    class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</body>

</html>