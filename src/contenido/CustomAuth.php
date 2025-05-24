<?php

session_start();

// 1) Recoger datos y validar
$fields = ['firstname','lastname','phone','address','career','email'];
foreach($fields as $f) {
  $$f = trim($_POST[$f] ?? '');
}
$password = $_POST['password'] ?? '';
$errors = [];
$old = compact(...$fields);

// Validaciones
if ($firstname === '') $errors[] = 'Nombre es obligatorio.';
if ($lastname  === '') $errors[] = 'Apellido es obligatorio.';
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Email inválido.';
if (strlen($password) < 6
    || !preg_match('/[A-Z]/',$password)
    || !preg_match('/[a-z]/',$password)
) {
  $errors[] = 'La contraseña debe tener al menos 6 caracteres, una mayúscula y una minúscula.';
}

// 2) Manejo de la foto (opcional)
$photoPath = null;
if (!empty($_FILES['photo']['tmp_name'])) {
  $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
  $photoPath = 'uploads/' . uniqid() . '.' . $ext;
  if (!move_uploaded_file($_FILES['photo']['tmp_name'], __DIR__ . '/' . $photoPath)) {
    $errors[] = 'Error al subir la foto.';
  }
}

// Si hay errores, guardo y vuelvo
if ($errors) {
  $_SESSION['errors'] = $errors;
  $_SESSION['old']    = $old;
  header('Location: /chavimochic/src/Views/usuario/auth/registration.php');
  exit;
}

// 3) Conexión a la base de datos
$dsn = 'mysql:host=localhost;dbname=chavi;charset=utf8mb4';
try {
  $pdo = new PDO($dsn, 'root', '', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
  ]);
} catch (PDOException $e) {
  die('Error de conexión: ' . $e->getMessage());
}

// 4) Insertar el usuario (is_approved = 0)
$stmt = $pdo->prepare("
  INSERT INTO users
    (firstname,lastname,phone,address,career,email,password,photo,is_approved,created_at,updated_at)
  VALUES
    (?,?,?,?,?,?,?,? ,0,NOW(),NOW())
");
$stmt->execute([
  $firstname, $lastname, $phone, $address,
  $career, $email,
  password_hash($password, PASSWORD_DEFAULT),
  $photoPath
]);

// 5) Mensaje de éxito y retorno al formulario
$_SESSION['success'] = 'Registro exitoso. Pronto un administrador aprobará tu cuenta.';
header('Location: /chavimochic/src/Views/usuario/auth/registration.php');
exit;

// 2) Capturar acción
$action = $_POST['action'] ?? null;
$id     = $_POST['id']     ?? null;

// 3) Lógica de cada acción
switch ($action) {
    case 'update_user':
        // Recoger y validar
        $fields = ['firstname','lastname','email','phone','address','career'];
        $errors = [];
        $data   = [];
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
            header("Location: /chavimochic/src/Views/administrador/general/selectedit-profile.php");
            exit;
        }
        // UPDATE
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
            $id
        ]);
        $_SESSION['success-user'] = 'Datos actualizados con éxito.';
        header("Location: /chavimochic/src/Views/administrador/general/selectedit-profile.php");
        exit;

    case 'update_photo':
        $errors = [];
        if (empty($_FILES['photo']['tmp_name'])) {
            $errors[] = 'Selecciona una foto.';
        } else {
            $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
            $photoPath = 'uploads/'.uniqid().'.'.$ext;
            if (!@move_uploaded_file($_FILES['photo']['tmp_name'], __DIR__.'/'.$photoPath)) {
                $errors[] = 'Error al subir la foto.';
            }
        }
        if ($errors) {
            $_SESSION['errors'] = $errors;
            header("Location: /chavimochic/src/Views/administrador/general/edit-profile.php");
            exit;
        }
        $pdo->prepare("UPDATE users SET photo=?, updated_at=NOW() WHERE id=?")
            ->execute([$photoPath, $id]);
        $_SESSION['success-photo'] = 'Foto actualizada correctamente.';
        header("Location: /chavimochic/src/Views/administrador/general/edit-profile.php");
        exit;

    case 'update_password':
        $password  = $_POST['password'] ?? '';
        $confirm   = $_POST['password_confirmation'] ?? '';
        $errors    = [];
        if (strlen($password) < 8) {
            $errors[] = 'Contraseña min. 8 caracteres.';
        }
        if ($password !== $confirm) {
            $errors[] = 'Las contraseñas no coinciden.';
        }
        if ($errors) {
            $_SESSION['errors'] = $errors;
            header("Location: /chavimochic/src/Views/administrador/general/edit-profile.php");
            exit;
        }
        $pdo->prepare("UPDATE users SET password=?, updated_at=NOW() WHERE id=?")
            ->execute([ password_hash($password, PASSWORD_DEFAULT), $id ]);
        $_SESSION['success-password'] = 'Contraseña actualizada correctamente.';
        header("Location: /chavimochic/src/Views/administrador/general/edit-profile.php");
        exit;

    default:
        // Acción desconocida
        header('HTTP/1.0 400 Bad Request');
        echo 'Acción inválida';
        exit;
}
