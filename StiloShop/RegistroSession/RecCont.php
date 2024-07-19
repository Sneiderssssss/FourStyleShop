<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperación de Contraseña</title>
    <link rel="stylesheet" href="css/RecCont.css">

</head>
<body>
    <div class="form-container">
        <h2>Recuperación de Contraseña</h2>
        <form action="recuperar_contraseña.php" method="post">
            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required placeholder="Introduce tu correo electrónico">
            <input type="submit" value="Recuperar Contraseña">
        </form>
        <div class="links">
            <a href="Login_y_register.php"><span class="icon">&#x1F519;</span>Volver</a>
            <a href="formulario_ayuda.php"><span class="icon">&#x2753;</span>¿Necesitas Ayuda?</a>
        </div>
    </div>
</body>
</html>
