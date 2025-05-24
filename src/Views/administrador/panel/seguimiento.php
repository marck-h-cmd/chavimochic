<?php
// require __DIR__ . '/../dash/plantilla.php';
require '../../../db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM requerimientos WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $requerimiento = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$requerimiento) {
            echo "Requerimiento no encontrado.";
            exit();
        }

        $stmt = $pdo->prepare("SELECT * FROM detalle_requerimientos WHERE REQUERIMIENTO_ID = :id ORDER BY F_CREACION DESC");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $detalles = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        echo "Error al obtener el requerimiento: " . $e->getMessage();
        exit();
    }
} else {
    echo "ID de requerimiento no válido.";
    exit();
}

?>

<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seguimiento de Requerimiento</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php

    if (isset($_SESSION['success'])) {
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "¡Éxito!",
                    text: "' . $_SESSION['success'] . '",
                    icon: "success",
                    customClass: {
                        confirmButton: "bg-green-500 text-white hover:bg-green-600 focus:ring-2 focus:ring-green-300 rounded-lg py-2 px-4"
                    }
                });
            });
        </script>';
        unset($_SESSION['success']);
    }

    if (isset($_SESSION['error'])) {
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "¡Error!",
                    text: "' . $_SESSION['error'] . '",
                    icon: "error",
                    customClass: {
                        confirmButton: "bg-red-500 text-white hover:bg-red-600 focus:ring-2 focus:ring-red-300 rounded-lg py-2 px-4"
                    }
                });
            });
        </script>';
        unset($_SESSION['error']);
    }
    ?>
</head>

<body class="bg-gray-100">
  <div class="max-w-screen-2xl mx-auto my-8 px-4">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-[#2e5382]">Crear Seguimiento</h1>
            <div class="w-1/4 mx-auto h-0.5 bg-[#64d423]"></div>
            <!-- <div cl 
             ass="mx-auto mt-2 w-1/5 h-1 bg-green-400"></div> -->
        </div>
        <form id="form" action="../../../store_detalle_requerimientos.php" method="POST" enctype="multipart/form-data"
            class="space-y-6">
            <!-- @csrf -->
            <input type="hidden" name="REQUERIMIENTO_ID" value="<?php echo $requerimiento['id']; ?>">
            <!-- Contenedor principal con Grid (2 columnas en md+) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Columna Izquierda -->
                <div class="space-y-1">
                    <!-- Título -->
                    <div>
                        <label for="TIPO_DOC" class="block text-gray-700 text-sm">TIPO_DOC</label>
                        <input type="text" id="TIPO_DOC" name="TIPO_DOC"
                            class="mt-1 w-full px-1 py-0.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                            required>
                    </div>

                    <div>
                        <label for="N_DOCUMENTO" class="block text-gray-700 text-sm">N_DOCUMENTO</label>
                        <input type="text" id="N_DOCUMENTO" name="N_DOCUMENTO"
                            class="mt-1 w-full px-1 py-0.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                            >
                    </div>
                    <div>
                        <label for="AREA_USUARIA" class="block text-gray-700 text-sm">AREA_USUARIA</label>
                        <input type="text" id="AREA_USUARIA" name="AREA_USUARIA"
                            class="mt-1 w-full px-1 py-0.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                            >
                    </div>
                    <div>
                        <label for="F_EMISION" class="block text-gray-700 text-sm">F_EMISION</label>
                        <input type="date" id="F_EMISION" name="F_EMISION" min="{{ date('Y-m-d') }}"
                            class="mt-1 w-full px-1 py-0.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 "
                            >
                    </div>

                    <!-- Subtítulo -->

                </div>

                <!-- Columna Derecha -->
                <div class="space-y-4">
                    <!-- Contenido con TinyMCE -->
                    <div>
                        <label for="AREA_RECEPTORA" class="block text-gray-700 text-sm">AREA_RECEPTORA</label>
                        <input type="text" id="AREA_RECEPTORA" name="AREA_RECEPTORA"
                            class="mt-1 w-full px-1 py-0.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                            >
                    </div>
                    <div>
                        <label for="F_RECEPCION" class="block text-gray-700 text-sm">F_RECEPCION</label>
                        <input type="date" id="F_RECEPCION" name="F_RECEPCION" min="{{ date('Y-m-d') }}"
                            class="mt-1 w-full px-1 py-0.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 "
                            >
                    </div>
                    <div>
                        <label for="SINTESIS_DEL_ASUNTO" class="block text-gray-700">SINTESIS_DEL_ASUNTO</label>
                        <textarea id="SINTESIS_DEL_ASUNTO" name="SINTESIS_DEL_ASUNTO" rows="2"
                            class="mt-1 w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </textarea>
                    </div>


                    <!-- Imagen (Drag & Drop) -->
                </div>
            </div>

            <!-- Botones de acción -->
            <div class="flex justify-end space-x-4">
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-700">
                    Guardar
                </button>
                <a href="/chavimochic/src/Views/administrador/panel/showpanel.php"
                    class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-700">
                    Volver
                </a>
            </div>
        </form>
        <div class="max-w-screen-2xl mx-auto my-8 px-4">
            <div class="overflow-x-auto bg-white rounded-lg shadow">
                <table class="min-w-full text-sm text-left text-gray-600 table-fixed">
                    <thead class="bg-gray-200 text-gray-700 uppercase">
                        <tr>
                            <th class="px-4 py-3">TIPO_DOC</th>
                            <th class="px-4 py-3">N_DOCUMENTO</th>
                            <th class="px-4 py-3">AREA_USUARIA</th>
                            <th class="px-4 py-3">F_EMISION</th>
                            <th class="px-4 py-3">AREA_RECEPTORA</th>
                            <th class="px-4 py-3">F_RECEPCION</th>
                            <th class="px-4 py-3 w-60">SINTESIS_DEL_ASUNTO</th>
                            <th class="px-4 py-3">PLAZO_DE_ATENCION</th>
                            <th class="px-4 py-3">SEMAFORO_DE_COLORES</th>
                            <th class="px-4 py-3">F_CREACION</th>
                            <th class="px-4 py-3">F_EDICION</th>
                            <th class="px-4 py-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($detalles as $detalle): ?>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-2 py-1"><?= htmlspecialchars($detalle['TIPO_DOC'] ?? '') ?></td>
                                <td class="px-2 py-1"><?= htmlspecialchars($detalle['N_DOCUMENTO'] ?? '') ?></td>
                                <td class="px-2 py-1"><?= htmlspecialchars($detalle['AREA_USUARIA'] ?? '') ?></td>
                                <td class="px-2 py-1"><?= htmlspecialchars($detalle['F_EMISION'] ?? '') ?></td>
                                <td class="px-2 py-1"><?= htmlspecialchars($detalle['AREA_RECEPTORA'] ?? '') ?></td>
                                <td class="px-2 py-1"><?= htmlspecialchars($detalle['F_RECEPCION'] ?? '') ?></td>
                                <td class="px-2 py-1 w-full whitespace-normal break-all">
                                    <?= htmlspecialchars($detalle['SINTESIS_DEL_ASUNTO'] ?? '') ?>
                                </td>
                                <td class="px-2 py-1"><?= htmlspecialchars($detalle['PLAZO_DE_ATENCION'] ?? '') ?></td>
                                <td class="px-2 py-1">
                                    <span
                                        class="px-2 py-1 rounded-full text-xs 
                                    <?= $detalle['SEMAFORO_DE_COLORES'] === 'VERDE' ? 'bg-green-100 text-green-800' : '' ?>
                                    <?= $detalle['SEMAFORO_DE_COLORES'] === 'AMARILLO' ? 'bg-yellow-100 text-yellow-800' : '' ?>
                                    <?= $detalle['SEMAFORO_DE_COLORES'] === 'ROJO' ? 'bg-red-100 text-red-800' : '' ?>
                                    <?= $detalle['SEMAFORO_DE_COLORES'] === 'NEGRO' ? 'bg-black text-white' : '' ?>
                                    <?= $detalle['SEMAFORO_DE_COLORES'] === 'NO PERMITIDO' ? 'bg-gray-800 text-white' : '' ?>
                                    <?= $detalle['SEMAFORO_DE_COLORES'] === 'NO RECEPCIONADO' ? 'bg-gray-300 text-gray-800' : '' ?>">
                                        <?= htmlspecialchars($detalle['SEMAFORO_DE_COLORES'] ?? '') ?>
                                    </span>
                                </td>
                                <td class="px-2 py-1"><?= htmlspecialchars($detalle['F_CREACION'] ?? '') ?></td>
                                <td class="px-2 py-1"><?= htmlspecialchars($detalle['F_EDICION'] ?? '') ?></td>
                                <td class="px-4 py-3 flex items-center justify-center space-x-4">
                                    <a href="/chavimochic/src/Views/administrador/panel/editdetalle.php?id=<?= urlencode($detalle['id']) ?> &d_REQUERIMIENTO_ID=<?= urlencode($detalle['REQUERIMIENTO_ID']) ?>"
                                       class="text-yellow-500 hover:text-yellow-700 flex items-center justify-center mt-3">
                                       
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 3l3 3-8 8H3v-3l8-8z" />
                                        </svg>
                                    </a>


                                    <button type="button"
                                        onclick="openDeleteModal(<?= $detalle['id'] ?>, '<?= addslashes($detalle['TIPO_DOC'] ?? '') ?>')"
                                        class="text-red-500 hover:text-red-700 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 6h18M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2M10 11v6M14 11v6M5 6h14l1 16a1 1 0 01-1 1H5a1 1 0 01-1-1L5 6z" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div class="flex justify-end text-sm mt-4">
                <!-- {{ $notici->links('pagination::tailwind') }} -->
            </div>
        </div>
    </div>


    <!-- Modal Editar -->
    

     <!-- Modal Eliminar -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 w-full h-full">
        <div class="flex items-center justify-center w-full h-full">
            <div class="bg-white p-7 rounded shadow-lg max-w-md w-full relative">
                <button class="absolute top-0.5 right-0.5 text-gray-500 hover:text-black text-3xl p-2"
                    onclick="closeDeleteModal()">&times;</button>
                <h2 class="text-xl font-bold mb-4">Eliminar Seguimiento</h2>
                <p>¿Estás seguro de que deseas eliminar el Seguimiento "<span id="requerimientoTitulo"></span>"?</p>

                <!-- Formulario de eliminación -->
                <form id="deleteForm" method="POST" action="../../../delete_detalles_requerimientos.php" class="mt-4">
                    <input type="hidden" name="d_id" id="deleteRequerimientoId">
                    <input type="hidden" name="d_REQUERIMIENTO_ID" value="<?= $detalle['REQUERIMIENTO_ID'] ?>">
                    <button type="submit"
                        class="bg-red-500 text-white px-6 py-2 rounded hover:bg-red-700">Aceptar</button>
                    <button type="button" onclick="closeDeleteModal()"
                        class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-700 mt-2">Cancelar</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        tinymce.init({
            selector: '#contenido',
            language: 'es_MX',
            branding: false,
            menubar: false,
            height: 150,
            relative_urls: false,
            remove_script_host: false,
            plugins: 'autolink lists link image charmap preview anchor code',
            toolbar: 'undo redo | formatselect | bold italic underline forecolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | removeformat | code',
            statusbar: false,
            link_title: false, // No se mostrará el campo de título en el diálogo de enlace
            link_target_list: [{
                title: 'Misma ventana',
                value: '_self'
            },
            {
                title: 'Nueva ventana',
                value: '_blank'
            }
            ]
        });



        tinymce.init({
            selector: '#edit_contenido',
            language: 'es_MX',
            branding: false,
            menubar: false,
            height: 240,
            relative_urls: false,
            remove_script_host: false,
            plugins: 'autolink lists link image charmap preview anchor code',
            toolbar: 'undo redo | formatselect | bold italic underline forecolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | removeformat | code',
            statusbar: false,
            link_title: false, // No se mostrará el campo de título en el diálogo de enlace
            link_target_list: [{
                title: 'Misma ventana',
                value: '_self'
            },
            {
                title: 'Nueva ventana',
                value: '_blank'
            }
            ]
        });

    </script>


    <script>

        function openDeleteModal(id, titulo) {
            console.log('Opening delete modal for ID:', id, 'Title:', titulo);
            checkModalElements();
            document.body.classList.add('modal-open');
            document.getElementById('requerimientoTitulo').textContent = titulo;
            document.getElementById('deleteRequerimientoId').value = id;
            document.getElementById('deleteModal').classList.remove('hidden');



        }

        function checkModalElements() {
            console.log('Delete Modal:', document.getElementById('deleteModal'));
            console.log('Title Element:', document.getElementById('requerimientoTitulo'));
            console.log('ID Input:', document.getElementById('deleteRequerimientoId'));
        }


        function closeDeleteModal() {
            document.body.classList.remove('modal-open');
            document.getElementById('deleteModal').classList.add('hidden');
        }

        // function openEditModal(buttonElement) {
        //     const detalle = JSON.parse(buttonElement.getAttribute('data-detalle'));
        //     document.getElementById('editId').value = detalle.id;
        //     document.querySelector('[name="E_TIPO_DOC"]').value = detalle.TIPO_DOC || '';
        //     document.querySelector('[name="E_N_DOCUMENTO"]').value = detalle.N_DOCUMENTO || '';
        //     document.querySelector('[name="E_AREA_USUARIA"]').value = detalle.AREA_USUARIA || '';


        //     document.querySelector('[name="E_F_EMISION"]').value = detalle.F_EMISION ? detalle.F_EMISION.split(' ')[0] : '';
        //     document.querySelector('[name="E_F_RECEPCION"]').value = detalle.F_RECEPCION ? detalle.F_RECEPCION.split(' ')[0] : '';

        //     document.querySelector('[name="E_AREA_RECEPTORA"]').value = detalle.AREA_RECEPTORA || '';


        //     if (typeof tinymce !== 'undefined' && tinymce.get('edit_contenido')) {
        //         tinymce.get('edit_contenido').setContent(detalle.SINTESIS_DEL_ASUNTO || '');
        //     } else {
        //         document.querySelector('[name="E_SINTESIS_DEL_ASUNTO"]').value = detalle.SINTESIS_DEL_ASUNTO || '';
        //     }

        //     document.getElementById('editForm').action = `../../../update_detalle_requerimiento.php`;


        //     document.getElementById('editModal').classList.remove('hidden');
        // }

        // function closeEditModal() {
        //     document.getElementById('editModal').classList.add('hidden');
        //     document.getElementById('editForm').reset();
        // }

        // document.addEventListener('DOMContentLoaded', function () {

        //     document.querySelectorAll('[onclick^="openDeleteModal"]').forEach(btn => {
        //         btn.addEventListener('click', function (e) {
        //             e.preventDefault();
        //             e.stopPropagation();


        //             const params = this.getAttribute('onclick')
        //                 .replace('openDeleteModal(', '')
        //                 .replace(')', '')
        //                 .split(',');

        //             const id = parseInt(params[0].trim());
        //             const title = params[1].trim().replace(/'/g, '');

        //             openDeleteModal(id, title);
        //         });
        //     });
        // });


        // document.getElementById('editForm').addEventListener('submit', async function (e) {
        //     e.preventDefault();
        //     this.submit();
        // });


    </script>

</body>
<style>
body.modal-open {
  overflow: hidden;
}
</style>

</html>