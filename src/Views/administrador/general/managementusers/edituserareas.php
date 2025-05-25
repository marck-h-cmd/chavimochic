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


try {
    $stmt = $pdo->prepare("SELECT requerimiento_id FROM area_detalle WHERE userId = ?");
    $stmt->execute([$id]); 
    $asignados = $stmt->fetchAll(PDO::FETCH_COLUMN);
} catch (PDOException $e) {
    die("Error al obtener requerimientos: " . $e->getMessage());
}

// Obtener todos los requerimientos disponibles
$requerimientos = $pdo->query("SELECT id, item FROM requerimientos")->fetchAll(PDO::FETCH_OBJ);



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
$old = $_SESSION['old'] ?? [];
unset($_SESSION['errors'], $_SESSION['old']);

// Función auxiliar para mostrar “valor anterior” o “valor de BD”
function old_or_db(array $old, object $user, string $field): string
{
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
  <form id="editForm" action="/chavimochic/src/contenido/updateuser.php" method="POST" enctype="multipart/form-data"
    class="space-y-6">
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
          <input type="text" id="firstname" name="firstname" value="<?= old_or_db($old, $user, 'firstname') ?>"
            class="mt-1 w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            required>
        </div>
        <!-- Apellido -->
        <div>
          <label for="lastname" class="block text-gray-700">Apellido</label>
          <input type="text" id="lastname" name="lastname" value="<?= old_or_db($old, $user, 'lastname') ?>"
            class="mt-1 w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            required>
        </div>
        <!-- Email -->
        <div>
          <label for="email" class="block text-gray-700">Email</label>
          <input type="email" id="email" name="email" value="<?= old_or_db($old, $user, 'email') ?>"
            class="mt-1 w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            required>
        </div>
        <!-- Carrera -->
        <div>
          <label for="career" class="block text-gray-700">Carrera</label>
          <input type="text" id="career" name="career" value="<?= old_or_db($old, $user, 'career') ?>"
            class="mt-1 w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            required>
        </div>
      </div>

      <!-- COLUMNA DERECHA -->
      <div class="space-y-4">
        <!-- Teléfono -->
        <div>
          <label for="phone" class="block text-gray-700">Teléfono</label>
          <input type="text" id="phone" name="phone" value="<?= old_or_db($old, $user, 'phone') ?>"
            class="mt-1 w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            required>
        </div>
        <!-- Dirección -->
        <div>
          <label for="address" class="block text-gray-700">Dirección</label>
          <input type="text" id="address" name="address" value="<?= old_or_db($old, $user, 'address') ?>"
            class="mt-1 w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            required>
        </div>
        <!-- Foto (opcional) -->
        <div>
          <label for="photo" class="block text-gray-700">Foto (opcional)</label>
          <input type="file" id="photo" name="photo" accept="image/*"
            class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
          <label for="tipo" class="block text-gray-700">Tipo de Usuario</label>
          <select id="tipo" name="tipo"
            class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            required>
            <option value="admin" <?= ($user->tipo == 'admin') ? 'selected' : '' ?>>Admin</option>
            <option value="superadmin" <?= ($user->tipo == 'superadmin') ? 'selected' : '' ?>>Superadmin</option>
          </select>
        </div>
        <!-- Campo para selección de requerimientos -->
        <div>
          <div class="relative">
            <label for="requerimientos" class="block text-gray-700">Requerimientos</label>
            <button type="button" id="toggle-requerimientos"
              class="mt-1 w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-md text-left focus:outline-none focus:ring-2 focus:ring-blue-500">
              <?= count($asignados) > 0 ? count($asignados) . ' requerimiento(s) seleccionado(s)' : 'Selecciona Requerimientos' ?>
            </button>
            <div id="requerimientos-menu"
              class="absolute z-10 w-full bg-white border border-gray-300 shadow-md rounded-md hidden mt-1">
              <div class="max-h-48 overflow-y-auto p-2">
                <?php if (!empty($requerimientos)): ?>
                  <?php foreach ($requerimientos as $req): ?>
                    <label class="flex items-center space-x-2 p-2 hover:bg-gray-100 rounded-md cursor-pointer">
                      <input type="checkbox" value="<?= $req->id ?>"
                        class="checkbox-requerimiento rounded text-blue-500 focus:ring-blue-500"
                        <?= in_array($req->id, $asignados) ? 'checked' : '' ?>>
                      <span><?= htmlspecialchars($req->item) ?></span>
                    </label>
                  <?php endforeach; ?>
                <?php else: ?>
                  <div class="p-2 text-gray-500">No hay requerimientos registrados</div>
                <?php endif; ?>
              </div>
            </div>
            <input type="hidden" name="requerimientos" id="requerimientos" value="<?= implode(',', $asignados) ?>">
          </div>
        </div>
      </div>
    </div>

</div>
</div>

<!-- Botones de acción -->
<div class="flex justify-center gap-4 mt-6">
  <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-700">
    Actualizar
  </button>
  <a href="/chavimochic/src/Views/administrador/general/managementusers/showusers.php"
    class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-700">
    Volver
  </a>
</div>
</form>
</div>
<!-- </div>
  </div>
</body>
</html> -->
<script>
  document.addEventListener("DOMContentLoaded", function () {
    // Manejo de Requerimientos
    const toggleButton = document.getElementById("toggle-requerimientos");
    const menu = document.getElementById("requerimientos-menu");
    const checkboxes = document.querySelectorAll(".checkbox-requerimiento");
    const hiddenInput = document.getElementById("requerimientos");
    let selectedRequerimientos = hiddenInput.value ? hiddenInput.value.split(',') : [];

    function updateButtonText() {
      const count = selectedRequerimientos.length;
      toggleButton.textContent = count > 0
        ? `${count} requerimiento(s) seleccionado(s)`
        : 'Selecciona Requerimientos';
    }

    toggleButton.addEventListener("click", function (e) {
      e.preventDefault();
      menu.classList.toggle("hidden");
    });

    document.addEventListener("click", function (event) {
      if (!toggleButton.contains(event.target) && !menu.contains(event.target)) {
        menu.classList.add("hidden");
      }
    });

    checkboxes.forEach(checkbox => {
      checkbox.addEventListener("change", function () {
        const id = this.value;
        if (this.checked) {
          if (!selectedRequerimientos.includes(id)) {
            selectedRequerimientos.push(id);
          }
        } else {
          selectedRequerimientos = selectedRequerimientos.filter(r => r !== id);
        }
        hiddenInput.value = selectedRequerimientos.join(",");
        updateButtonText();
      });
    });

    updateButtonText();
  });
</script>