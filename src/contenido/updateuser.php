<?php
//EDITAR LISTA USUARIOS
session_start();



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

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || ($_POST['form'] ?? '') !== 'updateuser') {
    header('Location: /chavimochic/src/Views/administrador/general/managementusers/showuser.php');
    exit;
}



$id        = intval($_POST['id'] ?? 0);
$fields    = ['firstname','lastname','email','career','phone','address','tipo'];
$data      = [];
$errors    = [];
foreach ($fields as $f) {
    $data[$f] = trim($_POST[$f] ?? '');
    if ($data[$f] === '') {
        $errors[] = "El campo $f es obligatorio.";
    }
}

$password     = $_POST['password'] ?? '';
if ($password !== '' && strlen($password) < 6) {
    $errors[] = 'La contraseña debe tener al menos 6 caracteres.';
}

/// 4) Validar la foto (si se envió una)
$hasNewPhoto = !empty($_FILES['photo']['tmp_name']);
if ($hasNewPhoto) {
    $mimes = ['image/jpeg', 'image/png', 'image/jpg'];
    if (!in_array($_FILES['photo']['type'], $mimes)) {
        $errors[] = 'Sólo JPG/PNG permitidos.';
    }
    if ($_FILES['photo']['size'] > 2 * 1024 * 1024) {
        $errors[] = 'La foto no puede superar 2MB.';
    }
}

// 5) Si hay errores, guardarlos en sesión y redirigir de vuelta a edición
if ($errors) {
    $_SESSION['errors'] = $errors;
    $_SESSION['old']    = $data;
    header("Location: /chavimochic/src/Views/administrador/general/managementusers/edituser.php?id=$id");
    exit;
}

// 6) Si llegan hasta aquí, primero —si hay foto nueva— borramos la antigua
if ($hasNewPhoto) {
    // 6a) Consultar la ruta actual de la foto en BD
    $stmt = $pdo->prepare("SELECT photo FROM users WHERE id = ?");
    $stmt->execute([$id]);
    $old = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!empty($old['photo'])) {
        // Construir la ruta física del archivo antiguo
        $oldPath = __DIR__ . '/../../' . ltrim($old['photo'], '/');
        // Si existe el archivo, lo eliminamos
        if (file_exists($oldPath)) {
            unlink($oldPath);
        }
    }

    // 6b) Guardar el nuevo fichero
    $ext     = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
    $newName = uniqid('usr_') . '.' . $ext;
    // Ruta relativa que guardaremos en BD
    $destRel = '/chavimochic/static/template/images/' . $newName;
    // Ruta absoluta donde se almacenará físicamente
    $destAbs = __DIR__ . '/../../static/template/images/' . $newName;

    if (!is_dir(dirname($destAbs))) {
        mkdir(dirname($destAbs), 0755, true);
    }
    if (!move_uploaded_file($_FILES['photo']['tmp_name'], $destAbs)) {
        $_SESSION['errors'] = ['Error al subir la foto.'];
        header("Location: /chavimochic/src/Views/administrador/general/managementusers/edituser.php?id=$id");
        exit;
    }
}

// 7) Ejecutar el UPDATE en la tabla users
//    Si hay foto nueva, incluimos la columna photo en el UPDATE
try {
    $pdo->beginTransaction();
    
    // 1. Actualizar datos del usuario
    if ($hasNewPhoto) {
        $sql = "UPDATE users SET
                    firstname = ?,
                    lastname = ?,
                    email = ?,
                    phone = ?,
                    address = ?,
                    career = ?,
                    tipo = ?,
                    photo = ?,
                    updated_at = NOW()
                WHERE id = ?";
        $params = [
            $data['firstname'],
            $data['lastname'],
            $data['email'],
            $data['phone'],
            $data['address'],
            $data['career'],
            $data['tipo'],
            $photoPath,
            $id
        ];
    } else {
        $sql = "UPDATE users SET
                    firstname = ?,
                    lastname = ?,
                    email = ?,
                    phone = ?,
                    address = ?,
                    career = ?,
                    tipo = ?,
                    updated_at = NOW()
                WHERE id = ?";
        $params = [
            $data['firstname'],
            $data['lastname'],
            $data['email'],
            $data['phone'],
            $data['address'],
            $data['career'],
            $data['tipo'],
            $id
        ];
    }
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    // 2. Manejar requerimientos asignados
    if (isset($_POST['requerimientos'])) {
        $requerimientos = array_filter(
            explode(',', $_POST['requerimientos']), 
            function($value) {
                return is_numeric($value) && $value > 0;
            }
        );
        
        // Eliminar asignaciones anteriores
        $deleteStmt = $pdo->prepare("DELETE FROM area_detalle WHERE userId = ?");
        $deleteStmt->execute([$id]);
        
        // Insertar nuevas asignaciones
        if (!empty($requerimientos)) {
            $insertStmt = $pdo->prepare("INSERT INTO area_detalle (userId, requerimiento_id) VALUES (?, ?)");
            
            foreach ($requerimientos as $reqId) {
                $insertStmt->execute([$id, intval($reqId)]);
            }
        }
    }
    
    $pdo->commit();
    $_SESSION['success-update'] = 'Usuario actualizado con éxito.';
    
} catch (PDOException $e) {
    $pdo->rollBack();
    $_SESSION['errors'] = ['Error al actualizar el usuario: ' . $e->getMessage()];
    error_log('Error en update_user: ' . $e->getMessage()); // Log del error
    header('Location: /chavimochic/src/Views/administrador/general/managementusers/showusers.php');
    exit;
}
header('Location: /chavimochic/src/Views/administrador/general/managementusers/showusers.php');
exit;



?>

