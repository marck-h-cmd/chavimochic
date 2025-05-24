<?php

//NO VALE*****************************************************************************++
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



session_start();
require_once __DIR__ . '/../../../dash/plantilla.php'; 
?>
  <?php if ($errors): ?>
    <div class="bg-red-100 text-red-700 p-4 mb-4 rounded">
      <?php foreach ($errors as $e): ?>
        <p>- <?= htmlspecialchars($e) ?></p>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

    <div class="max-w-screen-2xl mx-auto my-8 px-4">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-[#2e5382]">Editar Usuario</h1>
            <div class="w-1/4 mx-auto h-0.5 bg-[#64d423]"></div>
        </div>

        <form action="/chavimochic/src/contenido/updateuser.php?id=<?= $id ?>" method="POST" enctype="multipart/form-data">
            <!-- @csrf
            @method('PUT') -->
            <input type="hidden" name="id" value="<?= $id ?>">
            <input type="hidden" name="form" value="updateuser">
            <div class="mb-4">
                    <label for="firstname" class="block">Nombre</label>
                    <input type="text" id="firstname" name="firstname" value="<?= htmlspecialchars($old['firstname']) ?>" class="w-full px-4 py-2 border rounded" required>
            </div>
            <div class="mb-4">
                    <label for="lastname" class="block">Apellido</label>
                    <input type="text" id="lastname" name="lastname" value="<?= htmlspecialchars($old['lastname']) ?>" class="w-full px-4 py-2 border rounded" required>
            </div>
            <div class="mb-4">
                    <label for="email" class="block">Email</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($old['email']) ?>" class="w-full px-4 py-2 border rounded" required>
            </div>
            <div class="mb-4">
                    <label for="career" class="block">Carrera</label>
                    <input type="text" id="career" name="career" value="<?= htmlspecialchars($old['career']) ?>" class="w-full px-4 py-2 border rounded" required>
            </div>
            <div class="mb-4">
                    <label for="phone" class="block">Teléfono</label>
                    <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($old['phone']) ?>" class="w-full px-4 py-2 border rounded" required>
            </div>
            <div class="mb-4">
                    <label for="address" class="block">Dirección</label>
                    <input type="text" id="address" name="address" value="<?= htmlspecialchars($old['address']) ?>" class="w-full px-4 py-2 border rounded" required>
            </div>
            <div class="mb-4">
                    <label for="photo" class="block">Foto (opcional)</label>
                    <input type="file" id="photo" name="photo" class="w-full px-2 py-1 border rounded" accept="image/*">
            </div>
         
            <div class="flex space-x-4">
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-700">
                    Actualizar
                </button>
                <a href="/chavimochic/src/Views/administrador/general/managementusers/showusers.php" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-700">
                    Volver
                </a>
            </div>
        </form>
    </div>
<?php