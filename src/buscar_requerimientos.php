<?php
header('Content-Type: application/json');
require 'db.php'; // Incluye tu archivo de conexión a la base de datos

try {
    // Verificar si se envió un parámetro de búsqueda
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';

    if (!empty($search)) {
        // Consulta con filtro de búsqueda
        $stmt = $pdo->prepare("SELECT * FROM requerimientos 
                               WHERE ITEM LIKE :search 
                               OR N_EMISION LIKE :search 
                               OR N_DOCUMENTO LIKE :search");
        $stmt->execute(['search' => "%$search%"]);
    } else {
        // Consulta sin filtro (todos los registros)
        $stmt = $pdo->query("SELECT * FROM requerimientos");
    }

    $requerimientos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($requerimientos);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error al obtener los requerimientos: ' . $e->getMessage()]);
    http_response_code(500); // Establecer código de error interno del servidor
}
?>