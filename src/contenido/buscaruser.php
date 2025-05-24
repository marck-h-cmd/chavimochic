<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Protege la página
if (empty($_SESSION['user_id'])) {
    header('Location: /chavimochic/index.php');
    exit;
}
// Conexión PDO
try {
    $pdo = new PDO(
      'mysql:host=localhost;dbname=chavi;charset=utf8mb4',
      'root', '',
      [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    die("DB Error: " . $e->getMessage());
}

$q = trim($_GET['search'] ?? '');

// Prepara consulta con filtro
if ($q === '') {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE is_approved = 1 ORDER BY firstname");
    $stmt->execute();
} else {
    $stmt = $pdo->prepare("
      SELECT * FROM users
      WHERE is_approved = 1
        AND (
          firstname LIKE :q
          OR lastname  LIKE :q
          OR email     LIKE :q
        )
      ORDER BY firstname
    ");
    $like = "%{$q}%";
    $stmt->execute([':q' => $like]);
}

$users = $stmt->fetchAll(PDO::FETCH_OBJ);

// Devuelve sólo las filas <tr>…</tr> para reemplazar el <tbody>
foreach ($users as $u) {
    echo '<tr class="border-b hover:bg-gray-50">'
       . '<td class="px-4 py-3">' . htmlspecialchars($u->firstname) . '</td>'
       . '<td class="px-4 py-3">' . htmlspecialchars($u->lastname)  . '</td>'
       . '<td class="px-4 py-3">' . htmlspecialchars($u->email)     . '</td>'
       . '<td class="px-4 py-3">' . htmlspecialchars($u->career)    . '</td>'
       . '<td class="px-4 py-3">' . htmlspecialchars($u->phone)     . '</td>'
       . '<td class="px-4 py-3">' . htmlspecialchars($u->address)   . '</td>';
    echo '<td class="px-4 py-3">';
    if ($u->photo) {
        $url = htmlspecialchars($u->photo, ENT_QUOTES);
        echo <<<HTML
        <div class="px-8 py-0.1 text-center">
          <button 
            class="w-8 h-8 flex items-center justify-start rounded shadow cursor-pointer"
            onclick="openModal('{$url}', 'image')"
          >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6" viewBox="0 0 24 24">
              <path d="M18 22H4a2 2 0 0 1-2-2V6"/>
              <path d="m22 13-1.296-1.296a2.41 2.41 0 0 0-3.408 0L11 18"/>
              <circle cx="12" cy="8" r="2"/>
              <rect width="16" height="16" x="6" y="2" rx="2"/>
            </svg>
          </button>
        </div>
        HTML;
    } else {
        echo '<span>No hay foto</span>';
    }
    echo '</td>';

    // Acciones:
    $id   = (int)$u->id;
    $name = addslashes($u->firstname);
    echo <<<HTML
    <td class="px-4 py-3 flex items-center justify-center space-x-4">
      <a href="/chavimochic/src/Views/administrador/general/managementusers/editusers.php?id={$id}"
         class="text-yellow-500 hover:text-yellow-700 flex items-center justify-center mt-3"
         title="Editar">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M11 3l3 3-8 8H3v-3l8-8z" />
        </svg>
      </a>
      <form action="/chavimochic/src/contenido/deleteuser.php" method="POST" class="inline">
        <input type="hidden" name="id" value="{$id}">
        <button type="button"
                onclick="openDeleteModal({$id})"
                class="text-red-500 hover:text-red-700 flex items-center justify-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M3 6h18M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2M10 11v6M14 11v6M5 6h14l1 16a1 1 0 01-1 1H5a1 1 0 01-1-1L5 6z" />
          </svg>
        </button>
      </form>
    </td>
    HTML;

    echo '</tr>';
}
