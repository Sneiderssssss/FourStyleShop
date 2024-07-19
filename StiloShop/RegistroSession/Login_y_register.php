<?php
session_start();
// Redirecciona al index si el usuario ya ha iniciado sesión
if (isset($_SESSION['usuario'])) {
    header("location: ../index.php");
    exit(); // Termina el script para evitar que se ejecute más código
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="shortcut icon" href="../Inicio de login/imagenes/logo4.jpg" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <title>Login y Register</title>
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script src="https://apis.google.com/js/platform.js" async defer></script>
</head>

<body>
    <div class="container-form login
     <?php if (!isset($_GET['error']) || $_GET['error'] !== 'credenciales_incorrectas') {echo 'hide';} ?>">

        <div class="information">
            <div class="info-childs">
                <h2>¡¡Bienvenido nuevamente!!</h2>
                <p>Si aún no tienes una cuenta, por favor regístrate aquí</p>
                <input type="button" value="Registrarse" id="sign-up">
                <div class="icons">
                    <a href="../index.php"><i class="fa-solid fa-house"></i></a>
                </div>
            </div>
        </div>
        <div class="form-information">
            <div class="form-information-childs">
                <h2>Iniciar Sesión</h2>
                <div class="icons">
                    <!-- Botón de Google Sign-In -->
                    <div id="g_id_onload" 
                    data-client_id="765174794594-6dgu7f1a6gcd8p57q0m5g40vgvs0ajei.apps.googleusercontent.com" 
                    data-context="signin" 
                    data-ux_mode="popup" 
                    data-callback="handleCredentialResponse" 
                    data-auto_prompt="false">
                    </div>
                    <div class="g_id_signin" data-type="standard"></div>
                </div>
                <p>O Iniciar Sesión con una cuenta</p>
                <form class="form" action="php/login_usuario_be.php" method="POST">
                    <label>
                        <i class='bx bxs-envelope'></i>
                        <input type="email" placeholder="Correo Electrónico" name="EmaCli">
                    </label>
                    <label>
                        <i class='bx bxs-lock'></i>
                        <input type="password" placeholder="Contraseña" name="Cont">
                    </label>
                    <input type="submit" value="Iniciar Sesión">
                    <?php if (isset($_GET['error']) && $_GET['error'] == 'credenciales_incorrectas') : ?>
                        <p style="color: red; font-size: small;">Credenciales incorrectas</p>
                    <?php elseif (isset($_GET['error']) && $_GET['error'] == 'datos_incompletos') : ?>
                        <p style="color: red; font-size: small;">Por favor, complete todos los campos.</p>
                    <?php elseif (isset($_GET['error']) && $_GET['error'] == 'error_servidor') : ?>
                        <p style="color: red; font-size: small;">Error del servidor. Inténtalo de nuevo más tarde.</p>
                    <?php endif; ?>
                </form>
                <div class="ayuda">
                    <a href="RecCont.php" class="ayuda">Olvidé Mi Contraseña</a>
                    <a href="PQRS.php" class="ayuda">¿Necesitas Ayuda?</a>
                </div>
            </div>
        </div>
    </div>

    <div class="container-form register <?php if (isset($_GET['error']) && $_GET['error'] === 'credenciales_incorrectas') {
                                            echo 'hide';
                                        } ?>">
        <div class="information">
            <div class="info-childs">
                <h2>Bienvenido</h2>
                <p>Para Unirte a Nuestra Comunidad Por Favor Inicia Sesión Con Tus Datos</p>
                <input type="button" value="Iniciar Sesión" id="sign-in">
                <div class="icons">
                    <a href="../index.php"><i class="fa-solid fa-house"></i></a>
                </div>
            </div>
        </div>
        <div class="form-information">
            <div class="form-information-childs">
                <h2>Crear Una Cuenta</h2>
                <div class="icons">
                    <!-- Botón de Google Sign-In -->
                    <div id="g_id_onload" data-client_id="765174794594-6dgu7f1a6gcd8p57q0m5g40vgvs0ajei.apps.googleusercontent.com" data-context="signin" data-ux_mode="popup" data-callback="handleCredentialResponse" data-auto_prompt="false">
                    </div>
                    <div class="g_id_signin" data-type="standard"></div>
                </div>
                <p>O Completa el Siguiente Formulario</p>
                <form class="form" action="php/registro_usuario_be.php" method="POST" id="register-form">
                    <label>
                        <i class='bx bxs-user'></i>
                        <input type="text" placeholder="Nombres Completo" name="NomCliComp" required>
                    </label>
                    <label>
                        <i class='bx bxs-id-card'></i>
                        <input type="text" placeholder="Numero de documento" name="docCli" required>
                    </label>
                    <label>
                        <i class='bx bxs-envelope'></i>
                        <input type="email" placeholder="Correo Electronico" name="EmaCli" required>
                    </label>
                    <label>
                        <i class='bx bx-male-female'></i>
                        <input type="radio" name="Sexo" value="Masculino" required>Masculino
                        <input type="radio" name="Sexo" value="Femenino" required>Femenino
                    </label>
                    <label>
                        <i class='bx bxs-baby-carriage'></i>
                        <input type="date" name="FecCli" required>
                    </label>
                    <label>
                        <i class='bx bxs-map'></i>
                        <input type="text" placeholder="Dirección" name="Direccion" required>
                    </label>
                    <div class="password-container">
                        <label>
                            <i class='bx bxs-lock'></i>
                            <input type="password" placeholder="Contraseña" name="Cont" id="password" required>
                        </label>
                        <div id="password-requirements" class="requirements">
                            <ul>
                                <li class="bullet requirement-length">La contraseña debe tener al menos 8 caracteres.</li>
                                <li class="bullet requirement-uppercase">Debe contener al menos una letra mayúscula.</li>
                                <li class="bullet requirement-number">Debe contener al menos un número.</li>
                                <li class="bullet requirement-special">Debe contener al menos un carácter especial.</li>
                            </ul>
                        </div>
                    </div>
                    <label>
                        <i class='bx bx-lock'></i>
                        <input type="password" placeholder="Confirmar Contraseña" name="confirmar_contrasena" id="confirm-password" required>
                    </label>
                    <input type="submit" value="Registrarse">
                </form>
            </div>
        </div>
    </div>




    <script>
        function handleCredentialResponse(response) {
            const data = {
                id_token: response.credential
            };

            fetch('php/login_google.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => {
                    if (!response.ok) {
                        // Si la respuesta no es válida, lanza un error
                        throw new Error('Error en la solicitud: ' + response.statusText);
                    }
                    // Intenta convertir la respuesta en JSON
                    return response.text().then(text => {
                        try {
                            return JSON.parse(text);
                        } catch (err) {
                            throw new Error('La respuesta no es un JSON válido: ' + text);
                        }
                    });
                })
                .then(data => {
                    if (data.success) {
                        window.location.href = '../index.php';
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Se produjo un error: ' + error.message);
                });
        }
    </script>


    <script>
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('confirm-password');
        const passwordRequirements = document.getElementById('password-requirements');

        passwordInput.addEventListener('input', function() {
            const password = passwordInput.value;
            const validLength = password.length >= 8;
            const hasUppercase = /[A-Z]/.test(password);
            const hasNumber = /\d/.test(password);
            const hasSpecial = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/.test(password);

            const bulletList = passwordRequirements.querySelectorAll('.bullet');
            if (bulletList.length > 0) {
                bulletList[0].classList.toggle('green', validLength);
                bulletList[1].classList.toggle('green', hasUppercase);
                bulletList[2].classList.toggle('green', hasNumber);
                bulletList[3].classList.toggle('green', hasSpecial);
            }

            const isAllValid = validLength && hasUppercase && hasNumber && hasSpecial;
            passwordRequirements.style.display = isAllValid ? 'none' : 'block';
            document.querySelector('.container-form.register').classList.toggle('expanded', !isAllValid);
        });

        document.getElementById('register-form').addEventListener('submit', function(event) {
            if (passwordInput.value !== confirmPasswordInput.value) {
                event.preventDefault();
                alert('Las contraseñas no coinciden');
            }
        });
    </script>

    <script src="jp/script.js"></script>
</body>

</html>