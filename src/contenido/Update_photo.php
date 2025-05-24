<?php
session_start();

//FOTO CUENTA
// 1) Comprobar que el usuario está logueado
if (empty($_SESSION['user_id'])) {
    header('Location: /chavimochic/index.php');
    exit;
}

// 2) Validar que haya llegado un archivo
if (empty($_FILES['photo']['tmp_name'])) {
    $_SESSION['errors'] = ['Selecciona una foto.'];
    header('Location: /chavimochic/src/Views/administrador/general/edit-profile.php');
    exit;
}

// 3) Validar tipo y tamaño (igual que en Laravel)
$allowedMimes = ['image/jpeg','image/png','image/gif','image/jpg'];
if (!in_array($_FILES['photo']['type'], $allowedMimes)) {
    $_SESSION['errors'] = ['Sólo JPG o PNG permitidos.'];
    header('Location: /chavimochic/src/Views/administrador/general/edit-profile.php');
    exit;
}
if ($_FILES['photo']['size'] > 2 * 1024 * 1024) {
    $_SESSION['errors'] = ['La imagen no puede superar 2 MB.'];
    header('Location: /chavimochic/src/Views/administrador/general/edit-profile.php');
    exit;
}

// 4) Conectar a la base de datos
$dsn = 'mysql:host=localhost;dbname=chavi;charset=utf8mb4';
try {
    $pdo = new PDO($dsn,'root','',[
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die('Error de DB: '.$e->getMessage());
}

// 5) Recuperar ruta anterior y borrarla
$stmt = $pdo->prepare("SELECT photo FROM users WHERE id = ?");
$stmt->execute([ $_SESSION['user_id'] ]);
$old = $stmt->fetch(PDO::FETCH_ASSOC);
if (!empty($old['photo'])) {
    $oldPath = __DIR__ . '/../../' . $old['photo'];
    if (file_exists($oldPath)) unlink($oldPath);
}

// 6) Guardar el nuevo fichero
$ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
$newName = uniqid('usr').'.'.$ext;
// Carpeta destino (ajusta a tu ruta real)
$destRel   = '/chavimochic/static/template/images/'.$newName;
$destAbs   = __DIR__ . '/../../static/template/images/'.$newName;
if (!move_uploaded_file($_FILES['photo']['tmp_name'], $destAbs)) {
    $_SESSION['errors'] = ['Error al subir la foto.'];
    header('Location: /chavimochic/src/Views/administrador/general/selectedit-profile.php?tab=foto');
    exit;
}

// 7) Actualizar en la base de datos
$stmt = $pdo->prepare("UPDATE users SET photo = ?, updated_at = NOW() WHERE id = ?");
$stmt->execute([ $destRel, $_SESSION['user_id'] ]);

// 8) Redirigir con mensaje de éxito
$_SESSION['success-photo'] = 'Perfil actualizado correctamente.';
header('Location: /chavimochic/src/Views/administrador/general/selectedit-profile.php?tab=foto');
exit;
