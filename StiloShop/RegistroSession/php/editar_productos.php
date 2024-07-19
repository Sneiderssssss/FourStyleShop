<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="../css/UserProd.css"> 
</head>
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
        <section id="editar-producto">
            <h2>Editar Producto</h2>
            <form action="funciones/procesar_edicion_producto.php" method="post">
                <div class="form-group">
                    <label for="idProducto">Id del Producto:</label>
                    <input type="text" id="idProducto" name="idProducto" required>
                </div>
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="NomPro" name="NomPro" required>
                </div>
                <div class="form-group">
                    <label for="precio">Precio:</label>
                    <input type="number" id="PrePro" name="PrePro" min="0" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="descripcion">Descripción:</label>
                    <textarea id="descripcion" name="DesPro" rows="4" required></textarea>
                </div>
                <button class="button" type="submit">Editar Producto</button>
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
