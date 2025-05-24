<?php
// index.php

// include 'src/Controllers/Auth.php'; 
// $page_content = 'src/Views/usuario/auth/logout.php';


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-cover bg-center bg-[url('/static/images/laboratorio-mecanica.png')]">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white p-8 rounded-lg shadow-lg w-96 relative">
            <div class="absolute -top-16 left-1/2 transform -translate-x-1/2">
                <img src="/static//images/login.png" alt="Ilustración"
                     class="rounded-full h-32 w-32 border-4 border-white shadow-lg">
            </div>
            <h2 class="text-2xl font-bold text-center mb-6 mt-14">Iniciar Sesión</h2>

            <?php if (!empty($_SESSION['errors'])): ?>
                <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-md">
                    <ul>
                        <?php foreach ($_SESSION['errors'] as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php unset($_SESSION['errors']); ?>
            <?php endif; ?>

            <form method="POST" action="/login/post">
                <div class="mb-4">
                    <input type="email" name="email" placeholder="Correo electrónico"
                           required class="w-full px-4 py-2 border rounded-md"
                           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                </div>
                <div class="mb-4">
                    <input type="password" name="password" placeholder="Contraseña" required
                           class="w-full px-4 py-2 border rounded-md">
                </div>
                <div class="mb-6">
                    <button type="submit"
                        class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600 transition">
                        Iniciar Sesión
                    </button>
                </div>
                <p class="text-center text-sm">
                    ¿No tienes cuenta? <a href="/registration" class="text-blue-500 hover:underline">Regístrate</a>
                </p>
            </form>
        </div>
    </div>
</body>
</html>
