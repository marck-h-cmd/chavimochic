<?php

// 1) Conectar a la base de datos
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

//

$perPage = 10;
$page    = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset  = ($page - 1) * $perPage;

// Total de usuarios no aprobados
$totalStmt = $pdo->query("SELECT COUNT(*) FROM users WHERE is_approved = 0");
$total = $totalStmt->fetchColumn();

// Consulta de la página actual
$stmt = $pdo->prepare("SELECT * FROM users WHERE is_approved = 0 ORDER BY id DESC LIMIT ? OFFSET ?");
$stmt->bindValue(1, $perPage, PDO::PARAM_INT);
$stmt->bindValue(2, $offset, PDO::PARAM_INT);
$stmt->execute();
$persons = $stmt->fetchAll(PDO::FETCH_OBJ);

// Cálculo de páginas
$totalPages = ceil($total / $perPage);


?>
    <div class="max-w-screen-2xl mx-auto my-8 px-4">
        
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-[#2e5382]">Personas</h1>
            <div class="w-1/4 mx-auto h-0.5 bg-[#64d423]"></div>
        </div>

        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full text-sm text-left text-gray-600">
                <thead class="bg-gray-200 text-gray-700 uppercase">
                    <tr>
                        <th class="px-4 py-3">Nombre</th>
                        <th class="px-4 py-3">Apellido</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Carrera</th>
                        <th class="px-4 py-3">Teléfono</th>
                        <th class="px-4 py-3">Dirección</th>
                        <th class="px-4 py-3">Foto</th>
                        <th class="px-4 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                     <?php foreach ($persons as $p): ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-3"><?= htmlspecialchars($p->firstname) ?></td>
                            <td class="px-4 py-3"><?= htmlspecialchars($p->lastname) ?></td>
                            <td class="px-4 py-3"><?= htmlspecialchars($p->email) ?></td>
                            <td class="px-4 py-3"><?= htmlspecialchars($p->career) ?></td>
                            <td class="px-4 py-3"><?= htmlspecialchars($p->phone) ?></td>
                            <td class="px-4 py-3"><?= htmlspecialchars($p->address) ?></td>
                            <td class="px-4 py-3">
                                <?php if ($p->photo): ?>
                                <div class="px-8 py-0.1 text-center">
                                    <button 
                                        class="w-8 h-8 flex items-center justify-start rounded shadow cursor-pointer"
                                        onclick="openModal('<?= htmlspecialchars($p->photo) ?>')"
                                    >
                                        <svg 
                                            xmlns="http://www.w3.org/2000/svg" 
                                            fill="none" 
                                            stroke="currentColor" 
                                            stroke-width="2" 
                                            stroke-linecap="round" 
                                            stroke-linejoin="round" 
                                            class="w-6 h-6"
                                            viewBox="0 0 24 24"
                                        >
                                            <path d="M18 22H4a2 2 0 0 1-2-2V6"/>
                                            <path d="m22 13-1.296-1.296a2.41 2.41 0 0 0-3.408 0L11 18"/>
                                            <circle cx="12" cy="8" r="2"/>
                                            <rect width="16" height="16" x="6" y="2" rx="2"/>
                                        </svg>
                                    </button>
                                </div>
                               <?php else: ?>
                                    <span>No hay foto</span>
                               <?php endif; ?>
                            </td>
                            <td class="px-4 py-3 flex items-center justify-center space-x-4">
                                <?php if (!$p->is_approved): ?>
                                    <form action="/chavimochic/src/contenido/approve_user.php" method="POST">
                                         <input type="hidden" name="id" value="<?= $p->id ?>">
                                        <button type="submit" class="text-green-500 hover:text-green-700">Aprobar</button>
                                    </form>
                                <?php else: ?>
                                    <span class="text-green-500">Aprobado</span>
                                <?php endif; ?>
                                <form action="/chavimochic/src/contenido/delete_user.php" method="POST">
                                    <input type="hidden" name="id" value="<?= $p->id ?>">
                                    <button type="submit" class="text-red-500 hover:text-red-700">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="flex justify-end text-sm mt-4">
              <div class="mt-4">
                      <?php if ($page > 1): ?>
                          <a href="?page=<?= $page - 1 ?>"
                             class="px-3 py-1 bg-gray-300 rounded hover:bg-gray-400">« Anterior</a>
                      <?php endif; ?>
                      <span class="px-3 py-1"><?= "$page / $totalPages" ?></span>
                      <?php if ($page < $totalPages): ?>
                          <a href="?page=<?= $page + 1 ?>"
                             class="px-3 py-1 bg-gray-300 rounded hover:bg-gray-400">Siguiente »</a>
                      <?php endif; ?>
                </div>
        </div>
    </div>

    <div id="archivoModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white p-7 rounded shadow-lg max-w-7xl w-full relative">
            <button class="absolute top-0.5 right-0.5 text-gray-500 hover:text-black text-3xl p-2" onclick="closeModal()">×</button>
            <div id="modalContent"></div>
        </div>
    </div>

    <!-- @if (session('success-approve')) -->
    <?php if (!empty($_SESSION['success_approve'])): ?>
      <script>
        Swal.fire({
          title: "¡Aprobado!",
          text: "<?= $_SESSION['success_approve'] ?>",
          icon: "success",
          confirmButtonText: "OK"
        });
      </script>
      <?php unset($_SESSION['success_approve']); ?>
    <?php endif; ?>
      <!-- @elseif (session('success-destroy')) -->
     <?php if (!empty($_SESSION['success_delete'])): ?>
      <script>
        Swal.fire({
          title: "¡Eliminado!",
          text: "<?= $_SESSION['success_delete'] ?>",
          icon: "success",
          confirmButtonText: "OK"
        });
      </script>
      <?php unset($_SESSION['success_delete']); ?>
    <?php endif; ?>

<!-- @endif -->

<script>

    function openModal(imageUrl, type) {
    const modalContent = document.getElementById('modalContent');
    modalContent.innerHTML = `<img src="${imageUrl}" class="w-full max-h-[75vh] object-contain">`;
    document.getElementById('archivoModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('archivoModal').classList.add('hidden');
}

// 2) Leer sólo los usuarios no aprobados
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     if (isset($_POST['approve_id'])) {
//         $stmt = $pdo->prepare("UPDATE users SET is_approved = 1 WHERE id = ?");
//         $stmt->execute([ $_POST['approve_id'] ]);
//     }
//     if (isset($_POST['delete_id'])) {
//         $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
//         $stmt->execute([ $_POST['delete_id'] ]);
//     }
//     // Redirigir para evitar reenvío de formulario
//     header('Location: person.php?page=' . (isset($_GET['page']) ? intval($_GET['page']) : 1));
//     exit;
// }
</script>


<?php