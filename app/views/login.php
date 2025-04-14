<?php include "app/views/template/head.php" ?>
<style>
   
    body {
        background-image: url('dist/img/fondo.jpg');
        background-size: cover; 
        background-position: center;
        background-repeat: no-repeat;
    }
    .trans {
        background-color: rgba(0, 17, 51, 0.7);
        border-radius: 15px;
        padding: 20px; 
    }
    .card {
        border: none; 
    }
    
    .input-group-text {
    width: 40px; 
    text-align: center;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
}

.login-page {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    min-height: 100vh !important;
}

</style>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="card trans">
        <div class="card-body text-white">
            <h4 class="text-center">Bienvenido al Sistema DIRPOLES</h4>
            <h3 class="text-center">Inicio de sesión</h3>
            <form action="index.php?action=login" method="post">
                <div class="input-group-container">
                    <div class="input-group mb-3">
                        <input type="text" name="username" class="form-control" placeholder="Usuario" >
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-user"></span></div>
                        </div>
                    </div>
                    <p class="error-message" style="color: red; display: none; text-align: center;"></p>
                </div>
                    
                <div class="input-group-container">
                    <div class="input-group mb-3">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Contraseña" maxlength="8">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-eye" id="toggle-password" style="cursor: pointer;"></span>
                            </div>
                        </div>
                    </div>
                    <p class="error-message" style="color: red; display: none; text-align: center;"></p>
                </div>
                    <button type="submit" class="btn btn-primary btn-block">Iniciar</button>
                    <p id="error-message" style="color:red; text-align: center; <?= isset($error) ? '' : 'display: none;' ?>">
                        <?= isset($error) ? $error : '' ?>
                    </p>
                </form>
            <p class="login-box-msg" style="margin-top: 20px;">Dirección de Políticas Estudiantiles de la Universidad Politécnica Territorial Andrés Eloy Blanco</p>
        </div>
    </div>
</div>

<script src="dist/js/adminlte.min.js"></script>
<?php include 'template/script.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector("form");
    const usernameInput = form.querySelector("input[name='username']");
    const passwordInput = form.querySelector("input[name='password']");
    const errorMessage = document.getElementById("error-message");

    // Función para validar correo con dominios específicos
    const validateEmail = (email) => {
        const regex = /^[a-zA-Z0-9._%+-]+@(hotmail|yahoo|gmail|outlook)\.(com|es|net|org)$/i;
        return regex.test(email);
    };

    // Función de validación de campo con mensaje de error
    const validateField = (input, errorMessage, condition) => {
        const error = input.closest(".input-group-container").querySelector(".error-message");
        if (condition) {
            error.textContent = errorMessage;
            error.style.display = "block";
        } else {
            error.textContent = "";
            error.style.display = "none";
        }
    };

    // Función para ocultar mensaje de error global
    const hideError = () => {
        if (errorMessage) {
            errorMessage.style.display = "none";
        }
    };

    // Validación en tiempo real del campo de usuario
    usernameInput.addEventListener("input", () => {
        // Verificar si el correo es válido o no
        if (usernameInput.value.trim() === "") {
            validateField(usernameInput, "Ingrese un usuario", true);
        } else if (!validateEmail(usernameInput.value.trim())) {
            validateField(usernameInput, "Ingrese un correo electrónico válido", true);
        } else {
            validateField(usernameInput, "", false);
        }
        hideError();
    });

    // Validación de la contraseña en tiempo real
    passwordInput.addEventListener("input", () => {
        if (passwordInput.value.trim() === "") {
            validateField(passwordInput, "Ingrese una contraseña", true);
        } else if (passwordInput.value.length > 8) {
            validateField(passwordInput, "La contraseña no puede tener más de 8 caracteres", true);
        } else {
            validateField(passwordInput, "", false);
        }
        hideError();
    });

    // Validación final cuando se envíe el formulario
    form.addEventListener("submit", async function(event) {
        event.preventDefault();
        let valid = true;

        // Validación de campos vacíos
        if (usernameInput.value.trim() === "") {
            validateField(usernameInput, "Ingrese un usuario", true);
            valid = false;
        }

        if (passwordInput.value.trim() === "") {
            validateField(passwordInput, "Ingrese una contraseña", true);
            valid = false;
        }

        if (!valid) return;

        // Verificar si el correo es válido
        if (!validateEmail(usernameInput.value.trim())) {
            validateField(usernameInput, "Ingrese un correo electrónico válido", true);
            return;
        }

        // Verificar si la contraseña excede el límite
        if (passwordInput.value.length > 8) {
            validateField(passwordInput, "La contraseña no puede tener más de 8 caracteres", true);
            return;
        }

        try {
            // Verificar si el usuario existe
            const usuarioExiste = await verificarUsuarioExiste(usernameInput.value.trim());
            
            if (!usuarioExiste) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'El usuario no está registrado en el sistema'
                });
                return;
            }

            // Si el usuario existe, enviar formulario
            const formData = new FormData();
            formData.append('username', usernameInput.value.trim());
            formData.append('password', passwordInput.value.trim());

            enviarFormulario('index.php?action=login', formData);

        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error al verificar el usuario: ' + error.message
            });
        }
    });

    // Contraseña con visibilidad toggle
    const togglePassword = document.getElementById("toggle-password");

    if (togglePassword) {
        togglePassword.addEventListener("click", function() {
            const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
            passwordInput.setAttribute("type", type);

            if (type === "text") {
                togglePassword.classList.remove("fa-eye");
                togglePassword.classList.add("fa-eye-slash");
            } else {
                togglePassword.classList.remove("fa-eye-slash");
                togglePassword.classList.add("fa-eye");
            }
        });
    }
});

async function verificarUsuarioExiste(username) {
    try {
        const response = await fetch(`index.php?action=verificar_username`, {
            method: "POST",
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `username=${encodeURIComponent(username)}`
        });
        
        if (!response.ok) throw new Error('Error en la respuesta del servidor');
        
        const data = await response.json();
        return data.exists;
        
    } catch (error) {
        console.error('Error:', error);
        throw error;
    }
}


function enviarFormulario(action, formData) {
    fetch(action, {
        method: "POST",
        body: new URLSearchParams(formData),
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        }
    })
    .then((response) => response.json())
    .then((data) => {
        if (data.success) {
            Swal.fire({
                icon: "success",
                title: "¡Inicio de sesión exitoso!",
                timer: 3000,
                text: "Espere un momento, por favor.",
                showConfirmButton: false,
            }).then(() => {
                window.location.href = "index.php?action=inicio";
            });
        } else {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: data.message || "Error desconocido"
            });
        }
    })
    .catch((error) => {
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "Hubo un problema al procesar la solicitud."
        });
        console.error("Error en el envío:", error);
    });
}

</script>


<?php if (isset($_SESSION['mensaje'])): ?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            <?php if ($_SESSION['tipo_mensaje'] === 'error'): ?>
                toastr.error("<?php echo $_SESSION['mensaje']; ?>", "Error");
            <?php elseif ($_SESSION['tipo_mensaje'] === 'exito'): ?>
                toastr.success("<?php echo $_SESSION['mensaje']; ?>", "Excelente");
            <?php endif; ?>
        });

        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-bottom-right",
            "timeOut": "3000"
        }
    </script>
    <?php unset($_SESSION['mensaje'], $_SESSION['tipo_mensaje']); ?>
<?php endif; ?>
</body>
</html>
