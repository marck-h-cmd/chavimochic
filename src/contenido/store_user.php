<?php
//CREAR USUARIO REGISTROUSUARIOS
session_start();

$dsn = 'mysql:host=localhost;dbname=chavi;charset=utf8mb4';
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
    PDO::ATTR_EMULATE_PREPARES => false,
];
try {
    $pdo = new PDO($dsn, 'root', '', $options);
} catch (PDOException $e) {
    die('Error DB: ' . $e->getMessage());
}

$errors = [];

// 1) Validación de formulario
$fields = ['firstname','lastname','phone','address','career','email'];
foreach ($fields as $f) {
    $$f = trim($_POST[$f] ?? '');
}
$password = $_POST['password'] ?? '';

if ($firstname === '') $errors[] = 'El nombre es obligatorio.';
if ($lastname  === '') $errors[] = 'El apellido es obligatorio.';
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Email inválido.';
if (strlen($password) < 6
    || !preg_match('/[A-Z]/', $password)
    || !preg_match('/[a-z]/', $password)
) {
    $errors[] = 'La contraseña debe tener al menos 6 caracteres, una mayúscula y una minúscula.';
}
if ($career === '') $errors[] = 'La carrera es obligatoria.';
if ($phone  === '') $errors[] = 'El teléfono es obligatorio.';
if ($address=== '') $errors[] = 'La dirección es obligatoria.';

// 2) Manejo de la foto (opcional)
$rutaImagen = null;
if (!empty($_FILES['photo']['tmp_name'])) {
    // Validar tipo y tamaño
    $allowedMimes = ['image/jpeg','image/png','image/jpg'];
    if (!in_array($_FILES['photo']['type'], $allowedMimes)) {
        $errors[] = 'Sólo JPG o PNG permitidos.';
    }
    if ($_FILES['photo']['size'] > 2 * 1024 * 1024) {
        $errors[] = 'La imagen no puede superar 2 MB.';
    }

    if (!$errors) {
        $ext     = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $newName = uniqid('usr_') . '.' . $ext;
        $destRel = '/chavimochic/static/template/images/' . $newName;
        $destAbs = __DIR__ . '/../../static/template/images/' . $newName;

        if (!is_dir(dirname($destAbs))) {
            mkdir(dirname($destAbs), 0755, true);
        }

        if (!move_uploaded_file($_FILES['photo']['tmp_name'], $destAbs)) {
            $errors[] = 'Error al subir la foto.';
        } else {
            $rutaImagen = $destRel;
        }
    }
}

// 3) Si hay errores, guardarlos y volver
if ($errors) {
    $_SESSION['errors'] = $errors;
    // y opcionalmente los valores viejos para rellenar el formulario:
    $_SESSION['old'] = [
        'firstname'=>$firstname,
        'lastname'=>$lastname,
        'email'=>$email,
        'career'=>$career,
        'phone'=>$phone,
        'address'=>$address
    ];
    header('Location: /chavimochic/src/Views/administrador/general/managementusers/showusers.php'); // Ajusta según tu vista
    exit;
}

// 4) Insertar en BD
try {
    $hash = password_hash($password, PASSWORD_BCRYPT);
    $sql  = "INSERT INTO users
        (firstname, lastname, email, password, career, phone, address, photo, is_approved,created_at,updated_at)
        VALUES (?,?,?,?,?,?,?,?,1,NOW(),NOW())";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $firstname,
        $lastname,
        $email,
        $hash,
        $career,
        $phone,
        $address,
        $rutaImagen
    ]);
    $_SESSION['success'] = 'Usuario creado exitosamente.';
} catch (Exception $e) {
    $_SESSION['errors'] = ['Error al guardar en la base de datos: ' . $e->getMessage()];
}


// 5) Redirigir de vuelta al listado
header('Location: /chavimochic/src/Views/administrador/general/managementusers/showusers.php');
exit;
