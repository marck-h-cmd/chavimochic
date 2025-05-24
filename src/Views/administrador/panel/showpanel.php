<?php
if (isset($_GET['delete'])) {
    $url = strtok($_SERVER["REQUEST_URI"], '?'); // Elimina los parámetros de la URL
    echo "<script>
        window.history.replaceState({}, document.title, '$url');
    </script>";
}

// principalhome.php
// 1. Indica a la plantilla dónde está tu contenido:
$contenido = __DIR__ . '/show.php';

// 2. Llama a la plantilla:
require __DIR__ . '/../dash/plantilla.php';
?>
