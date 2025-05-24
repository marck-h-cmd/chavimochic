<?php
header('Content-Type: application/json');
require 'db.php'; // Incluye tu archivo de conexión a la base de datos

try {
    $stmt = $pdo->query("SELECT * FROM requerimientos");
    $requerimientos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($requerimientos);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error al obtener los requerimientos: ' . $e->getMessage()]);
    http_response_code(500); // Establecer código de error interno del servidor
}
?>