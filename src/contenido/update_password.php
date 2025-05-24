<?php
////CONTRASEÑA CUENTA
session_start();

// 1) Comprobar sesión
if (empty($_SESSION['user_id'])) {
    header('Location: /chavimochic/index.php');
    exit;
}

// 2) Recoger POST y validaciones
$pw      = $_POST['password']              ?? '';
$confirm = $_POST['password_confirmation'] ?? '';
$errors  = [];

if (strlen($pw) < 8) {
    $errors[] = 'La contraseña debe tener al menos 8 caracteres.';
}
if ($pw !== $confirm) {
    $errors[] = 'Las contraseñas no coinciden.';
}

if ($errors) {
    $_SESSION['errors'] = $errors;
    header('Location: /chavimochic/src/Views/administrador/general/selectedit-profile.php?tab=configuracion');
    exit;
}

// 3) Conectar a la base de datos
try {
    $pdo = new PDO(
      'mysql:host=localhost;dbname=chavi;charset=utf8mb4',
      'root','',
      [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    die('DB Error: '.$e->getMessage());
}

// 4) Actualizar contraseña usando password_hash (bcrypt por defecto)
$stmt = $pdo->prepare("UPDATE users SET password = ?, updated_at = NOW() WHERE id = ?");
$stmt->execute([
    password_hash($pw, PASSWORD_DEFAULT),
    $_SESSION['user_id']
]);

// 5) Redirigir con mensaje de éxito
$_SESSION['success-password'] = 'Contraseña actualizada correctamente.';
header('Location: /chavimochic/src/Views/administrador/general/selectedit-profile.php?tab=configuracion');
exit;
