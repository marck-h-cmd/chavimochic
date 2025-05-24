<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function vista_principal_admin()
{
    // Simplemente incluimos la plantilla
    include __DIR__ . '/../views/administrador/general/principal.php';
    exit;
}

// Mostrar la misma vista, pasando datos del usuario autenticado
function vista_admin()
{
    // Recuperamos al usuario (por ejemplo, de la sesión)
    $user = $_SESSION['user'] ?? null;

    // Si usas un diálogo de autenticación con PDO, podrías haber guardado
    // el array completo de usuario en $_SESSION['user'] al hacer login.

    // Hacemos disponible $user para la vista
    include __DIR__ . '/../views/administrador/general/principal.php';
    exit;
}
