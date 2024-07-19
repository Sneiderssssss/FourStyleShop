<?php
// Iniciar o reanudar la sesión
session_start();
include 'conexion_be.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel del vendedor - Tienda Online de Ropa</title>
    <link rel="shortcut icon" href="../../Inicio de login/imagenes/logo4.jpg" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="../css/user.css">
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
    <?php
      // Verificar si el usuario está autenticado y es un superusuario
      if (isset($_SESSION['superusuario']) && $_SESSION['superusuario'] === true) {
        // Mostrar enlaces para superusuario
        echo '<a href="../../Inicio de login/pagina2.php" title="Productos">Productos</a>';
        echo '<a href="superusuario.php" title="Opciones de Productos">Opciones de Productos</a>';
        echo '<a href="../../Inicio de login/pagina4.php" title="Contactos">Contactos</a>';
      } elseif (isset($_SESSION['usuario'])) {
        // Mostrar enlaces para usuarios autenticados (no superusuarios)
        echo '<a href="../../index.php" title="Inicio">Inicio</a>';
        echo '<a href="../../Inicio de login/" title="Sobre">Sobre</a>';
        echo '<a href="../../Inicio de login/pagina2.php" title="Productos">Productos</a>';
        echo '<a href="../../Inicio de login/pagina3.php" title="Reseñas">Reseñas</a>';
        echo '<a href="../../Inicio de login/pagina4.php" title="Contactos">Contactos</a>';
      } else {
      // Mostrar enlaces para usuarios no autenticados
      echo '<a href="../../index.php" title="Inicio">Inicio</a>';
      echo '<a href="../../Inicio de login/pagina1.php" title="Sobre">Sobre</a>';
      echo '<a href="../../Inicio de login/pagina2.php" title="Productos">Productos</a>';
      echo '<a href="../../Inicio de login/pagina3.php" title="Reseñas">Reseñas</a>';
      echo '<a href="../../Inicio de login/pagina4.php" title="Contactos">Contactos</a>';
        }
    ?>
  </nav>
  <div class="icons">
    <?php
    // Verificar si el usuario está autenticado
    if (!isset($_SESSION['usuario'])) {
        // Si el usuario no está autenticado, mostrar el icono de inicio de sesión
        echo '<a href="../Login y register/Login_y_register.php" title="Login" class="fa-regular fa-address-card"></a>';
    } else {
        // Si el usuario está autenticado, mostrar el icono de perfil
        echo '<a href="Perfil.php" title="Perfil" class="fas fa-user"></a>';
        
        // Mostrar el nombre de usuario si está establecido
        if (isset($_SESSION['nombre_usuario'])) {
            echo '<span>' . $_SESSION['nombre_usuario'] . '</span>';
        }
        
        // Mostrar el rol si el usuario es un superusuario (vendedor)
        if (isset($_SESSION['superusuario']) && $_SESSION['superusuario'] === true) {
            echo '<span> Vendedor</span>';
        }
        
        // Mostrar el botón de cerrar sesión
        echo '<a href="../php/cerrar_sesion.php" title="Cerrar Sesión" class="fa-solid fa-door-open"></a>';
    }
    ?>
</div>

  </header>


    <div class="container">
    <div class="content">
        <main>
            <section id="gestion-productos">
                <h2>Gestión de Productos</h2>
                <form action="gestion_pagina.php" method="post">
                    <label for="opciones_productos">¿Qué desea hacer?</label>
                    <select id="opciones_productos" name="opciones">
                        <option value="agregar_producto.php">Agregar Productos</option>
                        <option value="eliminar_producto.php">Eliminar Productos</option>
                        <option value="editar_productos.php">Editar Productos</option>
                    </select>
                    <button type="submit">Ir</button>
                </form>
            </section>

            <section id="gestion-pedidos">
                <h2>Gestión de Pedidos</h2>
                <form action="gestion_pagina.php" method="post">
                    <label for="opciones_pedidos">Selecciona una opción:</label>
                    <select id="opciones_pedidos" name="opciones">
                        <option value="lista_pedidos.php">Lista de Pedidos</option>
                        <option value="detalles_pedido.php">Detalles del Pedido</option>
                    </select>
                    <button type="submit">Ir</button>
                </form>
            </section>
        </main>
    </div>
    <div class="image">
        <img src="https://t1.uc.ltmcdn.com/es/posts/1/6/2/como_dirigir_una_tienda_de_ropa_40261_orig.jpg" alt="Descripción de la imagen">
    </div>
</div>


    <footer>
        <div class="containerq">
            <div class="footer-column">
                <h3>Sobre Nosotros</h3>
                <p>Descubre más sobre nuestra pasión por la moda y nuestro compromiso con la calidad y el estilo.</p>
            </div>
            <div class="footer-column">
                <h3>Nuestros Productos</h3>
                <p>Explora nuestra amplia gama de ropa para hombres, mujeres y niños, diseñada para satisfacer todos los estilos y ocasiones.</p>
            </div>
            <div class="footer-column">
                <h3>Contáctanos</h3>
                <p>¿Necesitas ayuda o tienes alguna pregunta? Ponte en contacto con nuestro equipo de atención al cliente.</p>
                <p>Email: info@StiloShop.com</p>
                <p>Teléfono: +57 3127055966</p>
                <p>Dirección: La Plata </p>
            </div>
        </div>
        <div class="social-media">
            <h3>Síguenos</h3>
            <ul class="social-icons">
                <li><a href=""><i class="fab fa-facebook"></i></a></li>
                <li><a href=""><i class="fab fa-twitter"></i></a></li>
                <li><a href=""><i class="fab fa-instagram"></i></a></li>
            </ul>
        </div>
        <div class="copyright">
            <p>&copy; 2024 StiloShop. Todos los derechos reservados por la Empresa de <a href="">ForSytale</a>.</p>
        </div>
    </footer>
    <script>
    // Deshabilitar la función de retroceso del navegador
    history.pushState(null, null, location.href);
    window.onpopstate = function () {
        history.go(1);
    };
</script>

</body>

</html>