<?php
// session_start();

// 1) Si no hay sesión, fuera
if (empty($_SESSION['user_id'])) {
    header('Location: /chavimochic/index.php');
    exit;
}

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

if (!$user) {
    // Si por alguna razón no existe el usuario, lo mandamos al login
    header('Location: /chavimochic/index.php');
    exit;
}
?>


    <div class="flex flex-col md:flex-row gap-6 p-6 bg-gray-100 min-h-screen">
      
        <div class="w-full md:w-1/3 bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Área Usuaria</h2>
            <div class="space-y-4">
                <div>
                    <h3 class="text-sm text-gray-700 font-medium">FOTO</h3>
                    <?php if (!empty($user['photo'])): ?>
                      <img src="<?= htmlspecialchars($user['photo']) ?>" alt="Foto de perfil" class="w-50 h-30 object-cover">
                    <?php else: ?>
                      <div class="w-20 h-20 bg-gray-300 text-gray-700 flex items-center justify-center rounded-full text-xl font-bold uppercase">
                           <?= strtoupper(substr($user['firstname'], 0, 1)) ?>
                      </div>
                     <?php endif; ?>
                </div>
                <div>
                    <h3 class="text-sm text-gray-700 font-medium">NOMBRES Y APELLIDOS</h3>
                    <p class="text-gray-500">
                       <?= htmlspecialchars($user['firstname']) ?> <?= htmlspecialchars($user['lastname']) ?>
                     </p>
                </div>
                <div>
                    <h3 class="text-sm text-gray-700 font-medium">CORREO</h3>
                    <p class="text-gray-500"><?= htmlspecialchars($user['email']) ?></p>
                </div>
                <div>
                    <h3 class="text-sm text-gray-700 font-medium">CARRERA</h3>
                    <p class="text-gray-500"><?= htmlspecialchars($user['career']) ?></p>
                </div>
                <div>
                    <h3 class="text-sm text-gray-700 font-medium">CONTACTO</h3>
                    <p class="text-gray-500"><?= htmlspecialchars($user['phone']) ?></p>
                </div>
                <div>
                    <h3 class="text-sm text-gray-700 font-medium">DIRECCIÓN</h3>
                    <p class="text-gray-500"><?= htmlspecialchars($user['address']) ?></p>
                </div>
            </div>
            <p class="text-sm text-gray-400 mt-4">Datos personales del Administrador</p>
        </div>

      
        <div class="w-full md:w-2/3 bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Ficha de Datos Personales</h2>
        
            <div class="border-b border-gray-300 mb-6">
                <nav class="flex space-x-4" aria-label="Tabs">
                   <button
                     class="tab px-3 py-2 text-sm font-medium <?= $tab==='datos'?'hover:text-indigo-600 hover:border-indigo-600':'text-gray-500 border-b-2 border-transparent' ?>"
                     data-tab="datos"
                   >Datos del Administrador</button>

                   <button
                     class="tab px-3 py-2 text-sm font-medium <?= $tab==='foto'?'hover:text-indigo-600 hover:border-indigo-600':'text-gray-500 border-b-2 border-transparent' ?>"
                     data-tab="foto"
                   >Foto</button>

                   <button
                     class="tab px-3 py-2 text-sm font-medium <?= $tab==='configuracion'?'hover:text-indigo-600 hover:border-indigo-600':'text-gray-500 border-b-2 border-transparent' ?>"
                     data-tab="configuracion"
                   >Configuración</button>

                </nav>
            </div>

         
            <div id="datos" class="tab-content">
                <form action="/chavimochic/src/contenido/Update_user.php" method="POST">
                    <!-- @csrf
                    @method('PUT') -->
                     <input type="hidden" name="form" value="update_user">
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label for="firstname" class="block text-sm font-medium text-gray-700">Nombres</label>
                            <input
                                type="text"
                                id="firstname"
                                name="firstname"
                                value="<?= htmlspecialchars($user['firstname']) ?>"
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                              >
                        </div>
                        <div>
                            <label for="lastname" class="block text-sm font-medium text-gray-700">Apellidos</label>
                            <input
                                    type="text"
                                    id="lastname"
                                    name="lastname"
                                    value="<?= htmlspecialchars($user['lastname']) ?>"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                  >
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                             <input
                              type="email"
                              id="email"
                              name="email"
                              value="<?= htmlspecialchars($user['email']) ?>"
                              required
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">Teléfono</label>
                           <input
                             type="text"
                             id="phone"
                             name="phone"
                             value="<?= htmlspecialchars($user['phone']) ?>"
                             required
                             class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                           >
                        </div>
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700">Dirección</label>
                            <input
                              type="text"
                              id="address"
                              name="address"
                              value="<?= htmlspecialchars($user['address']) ?>"
                              required
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                        </div>
                        <div>
                            <label for="career" class="block text-sm font-medium text-gray-700">Carrera</label>
                              <input
                                type="text"
                                id="career"
                                name="career"
                                value="<?= htmlspecialchars($user['career']) ?>"
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                              >
                        </div>
                    </div>

                    <div class="flex justify-end mt-6">
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg shadow hover:bg-green-700">
                            Actualizar
                        </button>
                    </div>
                </form>
            </div>

            <div id="foto" class="tab-content hidden">
              <h3 class="text-lg font-medium text-gray-800">Foto</h3>
              <form action="/chavimochic/src/contenido/Update_photo.php" method="POST" enctype="multipart/form-data">
                <!--<input type="hidden" name="form" value="update_photo">-->
                <div class="mt-4 flex items-center space-x-4">
                  <input 
                    type="file" 
                    id="photo" 
                    name="photo"
                    accept="image/jpeg,image/png"
                    class="block w-full text-sm text-gray-500"
                  >
                </div>
                <div class="flex justify-end mt-6 space-x-4">
                  <button 
                    type="submit" 
                    class="bg-green-600 text-white px-4 py-2 rounded-lg shadow hover:bg-green-700"
                  >Guardar Foto</button>
                  <!-- cancelar vuelve atrás -->
                  <button 
                    type="button" 
                    onclick="window.location.href='?tab=foto'" 
                    class="bg-gray-500 text-white px-4 py-2 rounded-lg shadow hover:bg-gray-600"
                  >Cancelar</button>
                </div>
              </form>
            </div>
            

            <div id="configuracion" class="tab-content hidden">
                <h3 class="text-lg font-medium text-gray-800">Configuración</h3>
                <form action="/chavimochic/src/contenido/update_password.php" method="POST">
                    <!-- @csrf
                    @method('PUT') -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mt-2">Nueva Contraseña</label>
                        <div class="relative">
                            <input 
                                type="password" 
                                id="password" 
                                name="password"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                oninput="validatePassword()"
                            >
                            <button 
                                type="button" 
                                class="absolute inset-y-0 right-0 px-3 text-gray-600"
                                onclick="togglePasswordVisibility('password')">
                                👁️
                            </button>
                        </div>
                        <div id="password-strength" class="text-sm mt-2"></div>
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Repita Contraseña</label>
                        <div class="relative">
                            <input 
                                type="password" 
                                id="password_confirmation" 
                                name="password_confirmation"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                readonly
                                oninput="validatePasswordConfirmation()"
                            >
                            <button 
                                type="button" 
                                class="absolute inset-y-0 right-0 px-3 text-gray-600"
                                onclick="togglePasswordVisibility('password_confirmation')">
                                👁️
                            </button>
                        </div>
                        <div id="password-confirmation-strength" class="text-sm mt-2"></div>
                        <div id="password-match" class="text-sm mt-2"></div>
                    </div>
                    <div class="flex justify-end mt-6 space-x-4">
                        <button
                         
                          type="submit"
                          readonly
                        >Guardar Contraseña</button>
                        <button
                          type="button"
                          onclick="window.location.search='?tab=configuracion'"
                          class="bg-gray-500 text-white px-4 py-2 rounded-lg shadow hover:bg-gray-600"
                        >Cancelar</button>

                    </div>
                </form>
            </div>

<?php
// success-user
 if (!empty($_SESSION['success-user'])): ?>
   <script>
    Swal.fire({
      title: "Actualizado!",
      text: <?= json_encode($_SESSION['success-user']) ?>,
      icon: "success",
      customClass: {
        confirmButton: 'bg-green-500 text-white hover:bg-green-600 focus:ring-2 focus:ring-green-300 rounded-lg py-2 px-4'
      }
    });
   </script>
 <?php
  unset($_SESSION['success-user']);
 endif;
?>

<?php
            // Incluye SweetAlert2 si aún no lo has cargado
            echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';

            // success-photo
            if (!empty($_SESSION['success-photo'])): ?>
              <script>
                Swal.fire({
                  title: "Actualizado!",
                  text: <?= json_encode($_SESSION['success-photo']) ?>,
                  icon: "success",
                  customClass: {
                    confirmButton: 'bg-green-500 text-white hover:bg-green-600 focus:ring-2 focus:ring-green-300 rounded-lg py-2 px-4'
                  }
                });
              </script>
            <?php
              unset($_SESSION['success-photo']);
            endif;
?>

<?php
// session_start();
// Incluye SweetAlert2 solo una vez en la cabecera de la página
echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';

if (!empty($_SESSION['success-password'])): ?>
  <script>
    Swal.fire({
      title: "¡Actualizado!",
      text: <?= json_encode($_SESSION['success-password']) ?>,
      icon: "success",
      customClass: {
        confirmButton: 'bg-green-500 text-white hover:bg-green-600 focus:ring-2 focus:ring-green-300 rounded-lg py-2 px-4'
      }
    });
  </script>
<?php unset($_SESSION['success-password']); endif; ?>







<script>
        
    document.querySelectorAll('.tab').forEach(button => {
        button.addEventListener('click', () => {
            const tab = button.dataset.tab;

           
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });

           
            document.querySelector(`#${tab}`).classList.remove('hidden');

           
            document.querySelectorAll('.tab').forEach(tabBtn => {
                tabBtn.classList.remove('text-indigo-600', 'border-indigo-600');
                tabBtn.classList.add('text-gray-500', 'border-transparent');
            });

           
            button.classList.add('text-indigo-600', 'border-indigo-600');
            button.classList.remove('text-gray-500', 'border-transparent');
        });
    });

        function togglePasswordVisibility(fieldId) {
        const inputField = document.getElementById(fieldId);
        inputField.type = inputField.type === "password" ? "text" : "password";
    }

   
    function validatePassword() {
        const password = document.getElementById("password").value;
        const strengthElement = document.getElementById("password-strength");
        let isValid = validateStrength(password, strengthElement);

        
        const confirmationField = document.getElementById("password_confirmation");
        confirmationField.readOnly = !isValid;


        
        if (isValid) validatePasswordMatch();
    }

function validatePasswordConfirmation() {
    const confirmationPassword = document.getElementById("password_confirmation").value;
    const strengthElement = document.getElementById("password-confirmation-strength");
    
  
    let isValid = validateStrength(confirmationPassword, strengthElement, false);

    if (isValid) {
        strengthElement.innerHTML = ""; 
    }

    validatePasswordMatch();
}
   
    function validatePasswordMatch() {
        const password = document.getElementById("password").value;
        const passwordConfirmation = document.getElementById("password_confirmation").value;
        const matchElement = document.getElementById("password-match");
        const saveButton = document.getElementById("save-button");

        if (passwordConfirmation === "") {
            matchElement.innerHTML = "";
            saveButton.disabled = true;
            return;
        }

       
        if (password === passwordConfirmation) {
            matchElement.innerHTML = "<span class='text-green-600'>Las contraseñas coinciden.</span>";
            saveButton.disabled = false;
        } else {
            matchElement.innerHTML = "<span class='text-red-600'>Las contraseñas no coinciden.</span>";
            saveButton.disabled = true;
        }
    }

    function validateStrength(password, strengthElement, showValidMessage) {
        let strengthMessage = "La contraseña debe tener:";
        let isValid = true;

        if (!/[A-Z]/.test(password)) {
            strengthMessage += " una mayúscula,";
            isValid = false;
        }
        if (!/[a-z]/.test(password)) {
            strengthMessage += " una minúscula,";
            isValid = false;
        }
        if (!/\d/.test(password)) {
            strengthMessage += " un número,";
            isValid = false;
        }
        if (password.length < 6) {
            strengthMessage += " al menos 6 caracteres,";
            isValid = false;
        }

        if (strengthElement) {
            if (isValid && showValidMessage) {
                strengthElement.innerHTML = "<span class='text-green-600'>La contraseña es válida.</span>";
            } else if (!isValid) {
                strengthElement.innerHTML = `<span class='text-red-600'>${strengthMessage.slice(0, -1)}.</span>`;
            } else {
                 strengthElement.innerHTML = ""; 
            }
        }

        return isValid;
    }
</script>

<style>
    .hidden {
        display: none;
    }
</style>
<?php