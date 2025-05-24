<?php
require 'db.php'; // Ajusta la ruta a tu archivo db.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar si se recibió el ID del requerimiento
    if (isset($_POST['d_id']) && is_numeric($_POST['d_id'])) {
        $id = $_POST['d_id'];

        try {
            $stmt = $pdo->prepare("DELETE FROM detalle_requerimientos WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $_SESSION['success'] = "Seguimiento eliminado correctamente.";
                   header("Location: /chavimochic/src/Views/administrador/panel/seguimientoarea.php?id=" . urlencode($_POST['d_REQUERIMIENTO_ID']));
                exit();
            } else {
                header('Location: /chavimochic/src/Views/administrador/panel/showpanel.php?delete=error');
                exit();
            }

        } catch (PDOException $e) {
            // Manejar errores de base de datos
            echo "Error al eliminar el seguimiento: " . $e->getMessage();
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