<?php
////ELIMINAR LISTA DDE USUARIOS
session_start();

// 1) Comprobar sesión
if (empty($_SESSION['user_id'])) {
    header('Location: /chavimochic/index.php');
    exit;
}

$dsn = 'mysql:host=localhost;dbname=chavi;charset=utf8mb4';
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
try {
    $pdo = new PDO($dsn,'root','',$options);
} catch (PDOException $e) {
    die('Error de DB: '.$e->getMessage());
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([ intval($_POST['id']) ]);
    $_SESSION['success_delete'] = 'Usuario eliminado correctamente.';
}


header('Location: /chavimochic/src/Views/administrador/general/persons/personusers.php');
exit;

