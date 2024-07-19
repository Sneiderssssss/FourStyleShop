<?php
include 'conexion_be.php';
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Productos</title>
    <link rel="stylesheet" href="../css/UserProd.css"> 

<body>
<header>

<input type="checkbox" name="" id="toggler">
<label for="toggler" class="fas fa-bars"></label>
<div class="logo1">
    <img src="../../Inicio de login/imagenes/logo3.png" alt="">
</div>
<a href="#" class="logo"> StiloShop<span>.</span></a>

<nav class="navbar">
    <a href="../../Inicio de login/index.php" title="Inicio">Inicio</a>
    <a href="../../Inicio de login/pagina1.php" title="Sobre">sobre</a>
    <a href="../../Inicio de login/pagina2.php" title="Productos">productos</a>
    <a href="../../Inicio de login/pagina3.php" title="reseñas">reseñas</a>
    <?php
    // Verificar si el usuario está autenticado
    if (isset($_SESSION['superusuario']) && $_SESSION['superusuario'] === true) {
        // Mostrar enlace solo para el superusuario
        echo '<a href="superusuario.php" title="Opciones de Productos">Opciones de Productos</a>';
    }
    ?>
    <a href="../../Inicio de login/pagina4.php" title="Contactos">contactos</a>
</nav>

<div class="icons">
    <a href="../Login y register/Login_y_register.php" title="Login" class="fa-regular fa-address-card"></a>
    <a href="Perfil.php" title="Perfil" class="fas fa-user"></a>
    <?php
    // Verificar si el usuario está autenticado
    if (isset($_SESSION['usuario'])) {
        echo '<a href="../php/cerrar_sesion.php" title="Cerrar Sesión" class="fa-solid fa-door-open"></a>';
    }
    ?>
</div>
</header>

<div class="container">
    <section id="eliminar-producto">
        <h2>Eliminar Producto</h2>
        <form action="funciones/procesar_eliminacion_producto.php" method="post">
            <div class="form-group">
                <label for="idProducto">Id del Producto:</label>
                <input type="text" id="idProducto" name="idProducto" required>
            </div>
            <div class="form-group">
                <label for="nombreProducto">Nombre del Producto:</label>
                <input type="text" id="nombreProducto" name="nombreProducto" required>
            </div>
            <button type="submit" class="button">Eliminar Producto</button>
        </form>
    </section>
</div>


    <footer>
        <div class="copyright">
            <p>&copy; 2024 StiloShop. Todos los derechos reservados por la Empresa de <a href="">ForSytale</a>.</p>
        </div>
    </footer>
</body>

</html>
