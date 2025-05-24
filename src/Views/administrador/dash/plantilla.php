<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['user_id'])) {
    header('Location: /chavimochic/index.php');  // o la ruta pública de tu login
    exit;
}


require_once __DIR__ . '/../../../contenido/Principal.php';

// Datos del usuario (rellena $_SESSION['user'] al hacer login)
$user = $_SESSION['user'] ?? null;

// Ruta al contenido dinámico (por ejemplo, en $content defines qué vista cargar)
// $content = $content ?? '';

$currentUri = $_SERVER['REQUEST_URI'];


// 2) Conectar y leer usuario
try {
    $pdo = new PDO(
      'mysql:host=localhost;dbname=chavi;charset=utf8mb4',
      'root','',
      [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]
    ); 
} catch (PDOException $e) {
    die('DB Error: '.$e->getMessage());
}


$stmt = $pdo->prepare("SELECT * FROM users WHERE id=? LIMIT 1");
$stmt->execute([ $_SESSION['user_id'] ]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
  <link rel="stylesheet" href="/chavimochic/static/admin_dash/dist/css/style.css">
  
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="/chavimochic/static/admin_dash/dist/tinymce/tinymce.min.js" referrerpolicy="origin"></script>
  <title>Dash</title>
</head>
<body class="text-gray-800 font-inter">

  <!-- Sidebar -->
  <aside 
    class="fixed left-0 top-0 w-[300px] h-full bg-[#1E5397] p-4 z-50 sidebar-menu transition-transform overflow-y-auto shadow-2xl"> 
    <a href="/chavimochic/src/Views/administrador/general/selectprincipal.php" class="flex items-center py-8 border-b border-[#98C560]">
      <img src="/chavimochic/static/template/images/logopechv3.png" alt="logo_labcam" class="max-w-full">
    </a>
    <ul class="mt-8">
      <h4 class="text-[#98C560] text-sm font-bold uppercase mb-3">Administración general</h4>
      <li class="mb-1">
        <a href="/chavimochic/src/Views/administrador/general/selectprincipal.php"
           class="flex items-center py-2 px-4 text-white hover:bg-[#98C560] rounded-md <?= ($_GET['action'] ?? '')==='adminPrincipal'?'bg-[#98C560]':'' ?>">
          <i class="ri-instance-line mr-3 text-lg"></i>
          <span class="text-sm">Principal</span>
        </a>
      </li>
      <?php $current = basename($_SERVER['PHP_SELF']); ?>
      <li id="menu-usuarios" class="mb-1 group cursor-pointer <?php echo in_array($current, ['personusers.php','showusers.php']) ? 'active' : ''; ?>">
                <a  
                    id="toggle-usuarios"
                    class="flex items-center py-2 px-4 text-white hover:bg-[#98C560] rounded-md">
                    <i class="ri-instance-line mr-3 text-lg"></i>
                    <span class="text-sm">Usuarios</span>
                    <i class="ri-arrow-right-s-line ml-auto"></i>
                </a>
                <ul class="pl-7 mt-2 hidden group-[.active]:block">
                    <li class="mb-4">
                        <a href="/chavimochic/src/Views/administrador/general/persons/personusers.php"
                            class="text-sm flex items-center py-2 px-4 rounded-md text-white">
                            <span
                                class="w-1.5 h-1.5 rounded-full mr-3 <?php echo $current == 'personusers.php' ? 'bg-[#98C560]' : 'bg-gray-300'; ?>"></span>
                            Lista de Usuarios
                        </a>
                    </li>
                    <li class="mb-4">
                        <a href="/chavimochic/src/Views/administrador/general/managementusers/showusers.php"
                            class="text-sm flex items-center py-2 px-4 rounded-md text-white">
                            <span
                                class="w-1.5 h-1.5 rounded-full mr-3 <?php echo $current == 'showusers.php' ? 'bg-[#98C560]' : 'bg-gray-300'; ?>"></span>
                            Registrar Usuario
                        </a>
                    </li>                
                </ul>
      </li>

      <li class="mb-1">
        <a href="/chavimochic/src/Views/administrador/general/selectedit-profile.php"
           class="flex items-center py-2 px-4 text-white hover:bg-[#98C560] rounded-md <?= ($_GET['action'] ?? '')==='editUser'?'bg-[#98C560]':'' ?>">
          <i class="ri-user-3-line mr-3 text-lg"></i>
          <span class="text-sm">Mi Cuenta</span>
        </a>
      </li>

      <h4 class="text-[#98C560] uppercase text-sm font-bold mb-3 mt-8">Pestañas</h4>
      <li class="mb-1">
        <a href="/chavimochic/src/Views/administrador/panel/showpanel.php"
           class="flex items-center py-2 px-4 text-white hover:bg-[#98C560] rounded-md <?= ($_GET['action'] ?? '')==='areaUsuaria'?'bg-[#98C560]':'' ?>">
          <i class="ri-folder-user-line mr-3 text-lg"></i>
          <span class="text-sm">Area Usuaria</span>
        </a>
      </li>
    </ul>
    <div class="fixed top-0 left-[300px] w-full h-full z-40 md:hidden sidebar-overlay backdrop-blur-sm"></div>
  </aside>
  <!-- End Sidebar -->

  <!-- Main -->
  <main class="w-full md:w-[calc(100%-300px)] md:ml-[300px] bg-gray-50 min-h-screen transition-all main">
    <section class="py-5 px-6 bg-white flex items-center shadow-md shadow-black/5 sticky top-0 left-0 z-30">
      <button type="button" class="text-2xl text-gray-600 sidebar-toggle">
        <i class="ri-menu-line"></i>
      </button>
      <ul class="ml-auto flex items-center">
        <li class="dropdown ml-3">
          <button type="button"
                  class="dropdown-toggle flex items-center gap-x-2 hover:text-[#98C560] group">
            <div class="relative inline-block bg-white p-[2.5px] rounded-full border-[1px] border-black group-hover:border-[#98C560]">
              <?php if (!empty($user['photo'])): ?>
                <img src="<?= htmlspecialchars($user['photo']) ?>"
                     alt="Foto de perfil"
                     class="w-12 h-12 rounded-full block object-cover">
              <?php else: ?>
                <div class="w-12 h-12 bg-gray-300 text-gray-700 flex items-center justify-center rounded-full text-xl font-bold uppercase">
                  <?= strtoupper(substr($user['firstname'], 0, 1)) ?>
                </div>
              <?php endif; ?>
            </div>
            <?php if ($user): ?>
              <div>
                <h4 class="text-[14.5px] font-medium">
                  <?= htmlspecialchars($user['firstname']) ?> <?= htmlspecialchars($user['lastname']) ?>
                </h4>
                <h4 class="text-[12.5px] font-normal">
                  <?= htmlspecialchars($user['email']) ?>
                </h4>
              </div>
            <?php endif; ?>
          </button>
          <ul class="dropdown-menu shadow-md shadow-black/5 z-30 hidden py-2 rounded-md bg-white border border-gray-100 w-[140px] text-black text-[15px]">
            <li>
              <a href="/user/edit_user.php"
                 class="flex items-center py-1.5 px-4 hover:text-[#98C560]"> Mi Perfil</a>
            </li>
            <li>
              <a href="#" onclick="confirmLogout()"
                 class="flex items-center py-1.5 px-4 hover:text-[#98C560]"> Cerrar Sesión</a>
            </li>
          </ul>
        </li>
      </ul>
    </section>
    <section class="d-flex px-6 py-9">
      <?php 
        // Si antes de require de la plantilla defines en la vista
        // una variable $contenido, aquí la incluirás:
        if (!empty($contenido)) {
          include $contenido;
        } 
      ?>
    </section>

  </main>

  <script src="https://unpkg.com/@popperjs/core@2"></script>
  <script src="/chavimochic/static/admin_dash/dist/js/script.js"></script>
  <style>
  /* Forzar fondo rojo y texto blanco en “Sí, salir” */
    .swal2-popup .swal2-styled.swal2-confirm {
      background-color: #d33 !important;
     color: #fff    !important;
  }
  /* Lo mismo para el botón “Cancelar”, si quieres que también sea rojo */
    .swal2-popup .swal2-styled.swal2-deny,
    .swal2-popup .swal2-styled.swal2-cancel {
      background-color: #6c757d !important;
      color: #fff    !important;
  }
  </style>

  <script>
    function confirmLogout() {
      Swal.fire({
        title: "¿Estás seguro?",
        text: "Se cerrará tu sesión",
        icon: "warning",
        iconColor: "#FFA500",          // <— color del icono
        showCancelButton: true,
        confirmButtonColor: "#d33", // <— color del botón “Sí, salir”
        cancelButtonColor:  "#6c757d", // <— color del botón “Cancelar”
        confirmButtonText: "Sí, salir",
        cancelButtonText:  "Cancelar"
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = '/chavimochic/src/Views/usuario/auth/logout.php';
        }
      });
    }
  </script>

<script>
// Al cargar la página, enlazamos el clic al <a> para alternar .active en el <li>
document.addEventListener('DOMContentLoaded', function() {
  const toggle = document.getElementById('toggle-usuarios');
  const padre = document.getElementById('menu-usuarios');
  toggle.addEventListener('click', function(e) {
    e.preventDefault(); // evita recargar la página al hacer clic
    padre.classList.toggle('active');
  });
});
</script>
</body>
</html>
