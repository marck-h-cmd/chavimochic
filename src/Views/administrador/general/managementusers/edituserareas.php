<?php

// session_start();
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

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    die("ID de usuario inválido.");
}

// 2) Obtener datos actuales del usuario desde la tabla `users`
try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
    $stmt->execute([$id]);
    $user = $stmt->fetch(PDO::FETCH_OBJ);
    if (!$user) {
        die("Usuario no encontrado.");
    }
} catch (PDOException $e) {
    die("Error en la base de datos: " . $e->getMessage());
}

// 3) Capturar posibles mensajes (flash) de validación
$errors = $_SESSION['errors'] ?? [];
$old    = $_SESSION['old']    ?? [];
unset($_SESSION['errors'], $_SESSION['old']);

// Función auxiliar para mostrar “valor anterior” o “valor de BD”
function old_or_db(array $old, object $user, string $field): string {
    if (isset($old[$field])) {
        return htmlspecialchars($old[$field]);
    }
    return isset($user->{$field}) ? htmlspecialchars($user->{$field}) : '';
}
?>
   <div class="max-w-screen-2xl mx-auto my-8 px-4">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-[#2e5382]">Editar Usuario</h1>
            <div class="w-1/4 mx-auto h-0.5 bg-[#64d423]"></div>
        </div>

        <!-- Si hay errores, mostrarlos arriba -->
        <?php if (!empty($errors)): ?>
          <div style="background: #fee2e2; color: #b91c1c; padding: 1rem; margin-bottom: 1rem; border-radius: .25rem;">
            <?php foreach ($errors as $e): ?>
              <p>- <?= htmlspecialchars($e) ?></p>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <!-- Formulario de edición -->
        <form id="editForm"
              action="/chavimochic/src/contenido/updateuser.php"
              method="POST"
              enctype="multipart/form-data"
              class="space-y-6"
        >
          <!-- Hidden: id + form -->
          <input type="hidden" name="id" value="<?= $id ?>">
          <input type="hidden" name="form" value="updateuser">

          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Coloquemos los campos en dos columnas (izq y derecha) -->
            <!-- COLUMNA IZQUIERDA -->
            <div class="space-y-4">
              <!-- Nombre -->
              <div>
                <label for="firstname" class="block text-gray-700">Nombre</label>
                <input
                  type="text"
                  id="firstname"
                  name="firstname"
                  value="<?= old_or_db($old, $user, 'firstname') ?>"
                  class="mt-1 w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                  required
                >
              </div>
              <!-- Apellido -->
              <div>
                <label for="lastname" class="block text-gray-700">Apellido</label>
                <input
                  type="text"
                  id="lastname"
                  name="lastname"
                  value="<?= old_or_db($old, $user, 'lastname') ?>"
                  class="mt-1 w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                  required
                >
              </div>
              <!-- Email -->
              <div>
                <label for="email" class="block text-gray-700">Email</label>
                <input
                  type="email"
                  id="email"
                  name="email"
                  value="<?= old_or_db($old, $user, 'email') ?>"
                  class="mt-1 w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                  required
                >
              </div>
              <!-- Carrera -->
              <div>
                <label for="career" class="block text-gray-700">Carrera</label>
                <input
                  type="text"
                  id="career"
                  name="career"
                  value="<?= old_or_db($old, $user, 'career') ?>"
                  class="mt-1 w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                  required
                >
              </div>
            </div>

            <!-- COLUMNA DERECHA -->
            <div class="space-y-4">
              <!-- Teléfono -->
              <div>
                <label for="phone" class="block text-gray-700">Teléfono</label>
                <input
                  type="text"
                  id="phone"
                  name="phone"
                  value="<?= old_or_db($old, $user, 'phone') ?>"
                  class="mt-1 w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                  required
                >
              </div>
              <!-- Dirección -->
              <div>
                <label for="address" class="block text-gray-700">Dirección</label>
                <input
                  type="text"
                  id="address"
                  name="address"
                  value="<?= old_or_db($old, $user, 'address') ?>"
                  class="mt-1 w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                  required
                >
              </div>
              <!-- Foto (opcional) -->
              <div>
                <label for="photo" class="block text-gray-700">Foto (opcional)</label>
                <input
                  type="file"
                  id="photo"
                  name="photo"
                  accept="image/*"
                  class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
              </div>
            </div>
          </div>

          <!-- Botones de acción -->
          <div class="flex justify-center gap-4 mt-6">
            <button
              type="submit"
              class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-700"
            >
              Actualizar
            </button>
            <a href="/chavimochic/src/Views/administrador/general/managementusers/showusers.php" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-700">
                Volver
            </a>
          </div>
        </form>
      </div>
    <!-- </div>
  </div>
</body>
</html> -->
