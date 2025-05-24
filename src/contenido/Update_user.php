<?php

////EDITAR CUENTA
session_start();

// 1) Conectar a la base de datos
$dsn = 'mysql:host=localhost;dbname=chavi;charset=utf8mb4';
try {
    $pdo = new PDO($dsn,'root','',[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
    die('Error de conexión: '.$e->getMessage());
}

// 2) Comprobar sesión
if (empty($_SESSION['user_id'])) {
    header('Location: /chavimochic/index.php');
    exit;
}

// 3) Cargar datos del usuario para tener $user siempre
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([ $_SESSION['user_id'] ]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// 4) Detectar qué formulario llegaron
// Usamos un campo oculto <input name="form" value="update_user|update_photo|update_password">
$form = $_POST['form'] ?? null;

if ($form === 'update_user') {
    // — Validaciones idénticas a antes —
    $fields = ['firstname','lastname','email','phone','address','career'];
    $errors = [];
    $data = [];
    foreach ($fields as $f) {
      $data[$f] = trim($_POST[$f] ?? '');
      if ($data[$f] === '') {
        $errors[] = ucfirst($f).' es obligatorio.';
      }
    }
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
      $errors[] = 'Email inválido.';
    }
    if ($errors) {
      $_SESSION['errors'] = $errors;
      header('Location: /chavimochic/src/Views/administrador/general/edit-profile.php');
      exit;
    }
    // — UPDATE —
    $stmt = $pdo->prepare("
      UPDATE users SET
        firstname=?, lastname=?, email=?, phone=?, address=?, career=?, updated_at=NOW()
      WHERE id=?
    ");
    $stmt->execute([
      $data['firstname'],
      $data['lastname'],
      $data['email'],
      $data['phone'],
      $data['address'],
      $data['career'],
      $_SESSION['user_id']
    ]);
    $_SESSION['success-user'] = 'Datos actualizados con éxito.';
    header('Location: /chavimochic/src/Views/administrador/general/selectedit-profile.php');
    exit;
    
}

if ($form === 'update_photo') {
    $errors = [];

    if (empty($_FILES['photo']['tmp_name'])) {
        $errors[] = 'Selecciona una foto.';
    } else {
        $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $photoName = uniqid() . '.' . $ext;
        $photoPath = '/chavimochic/static/template/images/' . $photoName;
        $destination = __DIR__ . '/../../' . $photoPath;

        // Obtener la foto anterior
        $stmt = $pdo->prepare("SELECT photo FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch();

        // Eliminar foto anterior si existe y no es un valor vacío o genérico
        if ($user && !empty($user['photo'])) {
            $oldPath = __DIR__ . '/../../' . $user['photo'];
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }

        // Subir nueva foto
        if (!move_uploaded_file($_FILES['photo']['tmp_name'], $destination)) {
            $errors[] = 'Error al subir la foto.';
        }
    }

    if ($errors) {
        $_SESSION['errors'] = $errors;
        header('Location: /chavimochic/src/Views/administrador/general/selectedit-profile.php');
        exit;
    }

    // Guardar ruta nueva en la base de datos
    $pdo->prepare("UPDATE users SET photo=?, updated_at=NOW() WHERE id=?")
        ->execute([$photoPath, $_SESSION['user_id']]);

    $_SESSION['success-photo'] = 'Foto actualizada correctamente.';
    header('Location: /chavimochic/src/Views/administrador/general/selectedit-profile.php');
    exit;
}



if ($form === 'update_password') {
    $pw      = $_POST['password']              ?? '';
    $confirm = $_POST['password_confirmation'] ?? '';
    $errors  = [];
    if (strlen($pw) < 8) {
      $errors[] = 'Contraseña min. 8 caracteres.';
    }
    if ($pw !== $confirm) {
      $errors[] = 'Las contraseñas no coinciden.';
    }
    if ($errors) {
      $_SESSION['errors'] = $errors;
      header('Location: /chavimochic/src/Views/administrador/general/edit-profile.php');
      exit;
    }
    $pdo->prepare("UPDATE users SET password=?, updated_at=NOW() WHERE id=?")
        ->execute([ password_hash($pw, PASSWORD_DEFAULT), $_SESSION['user_id'] ]);
    $_SESSION['success-password'] = 'Contraseña actualizada correctamente.';
    header('Location: /chavimochic/src/Views/administrador/general/edit-profile.php');
    exit;
}

// Si llegaste sin enviar ningún formulario, redirige
header('Location: /chavimochic/src/Views/administrador/general/selectedit-profile.php');
exit;

