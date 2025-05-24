<?php
require 'db.php'; // Ajusta la ruta a tu archivo db.php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar si se recibió el ID del requerimiento
    if (isset($_POST['id']) && is_numeric($_POST['id'])) {
        $id = $_POST['id'];

        try {
            $stmt = $pdo->prepare("DELETE FROM requerimientos WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                // Redirigir con un mensaje de éxito
                header('Location: /chavimochic/src/Views/administrador/panel/showpanel.php?delete=success');
                exit();
            } else {
                // Redirigir con un mensaje de error
                header('Location: /chavimochic/src/Views/administrador/panel/showpanel.php?delete=error');
                exit();
            }

        } catch (PDOException $e) {
            // Manejar errores de base de datos
            echo "Error al eliminar el requerimiento: " . $e->getMessage();
            exit();
        }

    } else {
        // ID no válido
        echo "ID de requerimiento no válido.";
        exit();
    }
} else {
    // Método no permitido
    header('HTTP/1.1 405 Method Not Allowed');
    echo "Método no permitido.";
    exit();
}
?>