<?php

session_start();

if (!empty($_SESSION['user_id'])) {
    header('Location:  /chavimochic/src/Views/administrador/dash/plantilla.php');
    exit;
}

// Recoge errores de sesión (si vienen de login_process.php)
$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['errors']);

$old = $_SESSION['old'] ?? [];
unset($_SESSION['old']);


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-cover bg-center bg-[url('static/images/laboratorio-mecanica.png')]">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white p-8 rounded-lg shadow-lg w-96 relative">
            <div class="absolute -top-16 left-1/2 transform -translate-x-1/2">
                <img src="static/images/login.png" alt="Ilustración"
                     class="rounded-full h-32 w-32 border-4 border-white shadow-lg">
            </div>
            <h2 class="text-2xl font-bold text-center mb-6 mt-14">Iniciar Sesión</h2>

             <?php if (!empty($errors)): ?>
               <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-md">
                 <ul class="list-disc pl-5">
                   <?php foreach ($errors as $e): ?>
                     <li><?= htmlspecialchars($e) ?></li>
                   <?php endforeach; ?>
                 </ul>
               </div>
             <?php endif; ?>

             <form method="POST" action="src/contenido/Auth.php">
               <div class="mb-4">
                 <input type="email" name="email" placeholder="Correo electrónico"
                        value="<?= htmlspecialchars($old['email'] ?? '') ?>" required
                        class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500">
               </div>
               <div class="mb-4">
                 <input type="password" name="password" placeholder="Contraseña" required
                        class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500">
               </div>
               <div class="mb-6">
                 <button type="submit"
                         class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600">
                   Iniciar Sesión
                 </button>
               </div>
               <p class="text-center text-sm">
                 ¿No tienes una cuenta?
                 <a href="/chavimochic/src/Views/usuario/auth/registration.php" class="text-blue-500 hover:underline">Registrarme</a>
               </p>
             </form>
        </div>
    </div>
</body>
</html>
