<?php
// register.php
session_start();

// Si ya está logueado, lo mando al dashboard
// if (!empty($_SESSION['user_id'])) {
//     header('Location: /chavimochic/src/Views/administrador/dash/plantilla.php');
//     exit;
// }

// Recojo errores y valores anteriores
$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['errors']);

$old = $_SESSION['old'] ?? [];
unset($_SESSION['old']);

$success = $_SESSION['success'] ?? '';
unset($_SESSION['success']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro de Usuario</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-cover bg-center bg-[url('/chavimochic/static/images/laboratorio-mecanica.png')]">

 <div class="max-w-md w-full space-y-8">
  <?php if($success): ?>
      <div class="mb-8 p-6 bg-white border border-green-400 font-bold text-black-900 rounded-lg text-center shadow-md">
         <p><?= htmlspecialchars($success) ?></p>
         <div class="mt-7 flex justify-center">
          <a href="/chavimochic/index.php"
             class="bg-green-500 text-white px-5 py-2 rounded-lg text-lg font-semibold hover:bg-green-600 transition duration-300 flex items-center justify-center">
             Iniciar sesión
         </a>
        </div>
      </div>
  <?php else: ?>
    
    <!-- <div class="max-w-md w-full space-y-8"> -->
            <div class="bg-white shadow rounded-lg">
                <h3 class="text-2xl font-bold text-center py-4 bg-gray-50 border-b">Registro de Usuario</h3>
                <div class="px-8 py-6">
                    <?php if($errors): ?>
                      <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-md">
                        <ul class="list-disc pl-5">
                          <?php foreach($errors as $e): ?>
                            <li><?= htmlspecialchars($e) ?></li>
                          <?php endforeach; ?>
                        </ul>
                      </div>
                    <?php endif; ?>

                    <form action="/chavimochic/src/contenido/CustomAuth.php" method="POST" enctype="multipart/form-data" class="space-y-4">
                        <div class="mb-4">
                          <input type="text" name="firstname" placeholder="Nombre"
                               value="<?= htmlspecialchars($old['firstname'] ?? '') ?>"
                               required
                               class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-blue-500">
                          <?php if (isset($errors['firstname'])): ?>
                              <span class="text-red-500 text-sm"><?= htmlspecialchars($errors['firstname']) ?></span>
                          <?php endif; ?>
                        </div>

                        <div class="mb-4">
                         <input type="text" name="lastname" placeholder="Apellido"
                              value="<?= htmlspecialchars($old['lastname'] ?? '') ?>"
                              required
                              class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-blue-500">
                          <?php if (isset($errors['lastname'])): ?>
                               <span class="text-red-500 text-sm"><?= htmlspecialchars($errors['lastname']) ?></span>
                          <?php endif; ?>
                        </div>

                        <div class="mb-4">
                          <input type="text" name="phone" placeholder="Teléfono"
                                value="<?= htmlspecialchars($old['phone'] ?? '') ?>"
                                required
                                class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-blue-500">
                          <?php if (isset($errors['phone'])): ?>
                              <span class="text-red-500 text-sm"><?= htmlspecialchars($errors['phone']) ?></span>
                          <?php endif; ?>
                        </div>

                        <div class="mb-4">
                          <input type="text" name="address" placeholder="Dirección"
                                 value="<?= htmlspecialchars($old['address'] ?? '') ?>"
                                 required
                                 class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-blue-500">
                          <?php if (isset($errors['address'])): ?>
                              <span class="text-red-500 text-sm"><?= htmlspecialchars($errors['address']) ?></span>
                          <?php endif; ?>
                        </div>

                        <div class="mb-4">
                          <input type="text" name="career" placeholder="Carrera"
                                 value="<?= htmlspecialchars($old['career'] ?? '') ?>"
                                 required
                                 class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-blue-500">
                          <?php if (isset($errors['career'])): ?>
                              <span class="text-red-500 text-sm"><?= htmlspecialchars($errors['career']) ?></span>
                          <?php endif; ?>
                        </div>

                        <div class="mb-4">
                          <input type="email" name="email" placeholder="Email"
                                 value="<?= htmlspecialchars($old['email'] ?? '') ?>"
                                 required
                                 class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-blue-500">
                          <?php if (isset($errors['email'])): ?>
                            <span class="text-red-500 text-sm"><?= htmlspecialchars($errors['email']) ?></span>
                          <?php endif; ?>
                        </div>

                        <div class="mb-4">
                                  <div class="relative">
                                    <input type="password" name="password" id="password"
                                           placeholder="Contraseña" required
                                           class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-blue-500">
                                    <div class="mt-2 flex items-center">
                                      <input type="checkbox" onclick="togglePass()" class="h-4 w-4">
                                      <label class="ml-2 text-sm text-gray-600">Mostrar contraseña</label>
                                    </div>
                                  </div>
                                  <?php if (isset($errors['password'])): ?>
                                     <span class="text-red-500 text-sm"><?= htmlspecialchars($errors['password']) ?></span>
                                  <?php endif; ?>
                        </div>
                        <div class="mb-4">
                        <button type="submit"
                                 class="w-full bg-gray-900 text-white py-2 rounded-md hover:bg-gray-800 transition">
                                    Registrarse
                        </button>
                        </div>
                        <div class="mb-1">
                            <p class="text-center text-sm">
                                    ¿Ya tienes cuenta?
                               <a href="/chavimochic/index.php" class="text-blue-500 hover:underline">
                                      Iniciar sesión
                               </a>
                            </p>
                        </div>
                     </form>
                </div>
            </div>
  </div>
  <script>
  function togglePass() {
    const p = document.getElementById('password');
    p.type = p.type === 'password' ? 'text' : 'password';
  }
  </script>
 <?php endif; ?>
</body>
</html>
