<?php
session_start();

// 1) Recoger y validar datos del formulario
$email    = trim($_POST['email']    ?? '');
$password =        $_POST['password'] ?? '';
$errors   = [];
$old      = ['email' => $email];

if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Debes ingresar un correo válido.';
}
if (strlen($password) < 6) {
    $errors[] = 'La contraseña debe tener al menos 6 caracteres.';
}

if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    $_SESSION['old']    = $old;
    header('Location: /chavimochic/index.php');
    exit;
}

// 2) Conectar a la base de datos (ajusta host, bd, usuario y pass)
$dsn = 'mysql:host=localhost;dbname=chavi;charset=utf8mb4';
try {
    $pdo = new PDO($dsn, 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die('Error de conexión: ' . $e->getMessage());
}

// 3) Consultar usuario usando la columna `password`
$stmt = $pdo->prepare('
    SELECT 
      id, 
      password,    -- aquí está tu hash
      is_approved 
    FROM users 
    WHERE email = ? 
    LIMIT 1
');
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// 4) Validar credenciales y estado
if (!$user || !password_verify($password, $user['password'])) {
    $errors[] = 'Credenciales incorrectas.';
} elseif (!$user['is_approved']) {
    $errors[] = 'Tu cuenta aún no ha sido aprobada por un administrador.';
}

if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    $_SESSION['old']    = $old;
    header('Location: /chavimochic/index.php');
    exit;
}

// 5) Login exitoso: guardo sesión y redirijo a la plantilla
$_SESSION['user_id'] = $user['id'];
header('Location: /chavimochic/src/Views/administrador/general/selectprincipal.php');
exit;



// anterior crud
// function showLoginForm() {
//     include 'index.php';
// }

// function loginUser($data) {
//     $email = trim($data['email'] ?? '');
//     $password = trim($data['password'] ?? '');

//     // Validación simple
//     if (empty($email) || empty($password)) {
//         $_SESSION['errors'] = ['Todos los campos son obligatorios.'];
//         header('Location: index.php');
//         exit;
//     }

//     try {
//         // Conexión a la base de datos (ajusta con tus datos)
//         $pdo = new PDO('mysql:host=localhost;dbname=dashboard', 'root', '');
//         $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
//         $stmt->execute([$email]);
//         $user = $stmt->fetch(PDO::FETCH_ASSOC);

//         if ($user && password_verify($password, $user['password'])) {
//             $_SESSION['user_id'] = $user['id'];
//             $_SESSION['email'] = $user['email'];
//             header('Location: Views/administrador/dashboard/plantilla.php');
//             exit;
//         } else {
//             $_SESSION['errors'] = ['Correo o contraseña incorrectos.'];
//             header('Location: index.php');
//             exit;
//         }
//     } catch (PDOException $e) {
//         $_SESSION['errors'] = ['Error de conexión: ' . $e->getMessage()];
//         header('Location: index.php');
//         exit;
//     }
// }

// function logoutUser() {
//     session_destroy();
//     header('Location: index.php');
//     exit;
// }


        // $host     = '127.0.0.1';
        // $port     = '3306';s
        // $dbname   = 'dashboard';
        // $user     = 'root';
        // $pass     = '';

        // $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8";
        // $pdo = new \PDO(
        //     $dsn,
        //     $user,
        //     $pass,
        //     [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
        // );

        // $this->userModel = new User($pdo);