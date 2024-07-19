<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>StiloShop</title>
  <link rel="shortcut icon" href="imagenes/logo4.jpg" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/paginas.css">
  <link rel="stylesheet" href="css/fotter.css">
  <link rel="stylesheet" href="css/pagina5.css">
  <link rel="stylesheet" href="../css/pagina.css">
  <link rel="stylesheet" href="css/detalles.css">
  <script src="../jp/validacion.js"></script>
</head>

<body>
  <header>

    <input type="checkbox" name="" id="toggler">
    <label for="toggler" class="fas fa-bars"></label>
    <div class="logo1">
      <img src="imagenes/logo3.png" alt="">
    </div>
    <a href="#" class="logo"> StiloShop<span>.</span></a>

    <nav class="navbar">
      <?php
      // Verificar si el usuario está autenticado y es un superusuario
      if (isset($_SESSION['superusuario']) && $_SESSION['superusuario'] === true) {
        // Mostrar enlaces para superusuario
        echo '<a href="pagina2.php" title="Productos">Productos</a>';
        echo '<a href="../RegistroSession/php/superusuario.php" title="Opciones de Productos">Opciones de Productos</a>';
        echo '<a href="pagina4.php" title="Contactos">Contactos</a>';
      } elseif (isset($_SESSION['usuario'])) {
        // Mostrar enlaces para usuarios autenticados (no superusuarios)
        echo '<a href="../index.php" title="Inicio">Inicio</a>';
        echo '<a href="pagina1.php" title="Sobre">Sobre</a>';
        echo '<a href="pagina2.php" title="Productos">Productos</a>';
        echo '<a href="pagina3.php" title="Reseñas">Reseñas</a>';
        echo '<a href="pagina4.php" title="Contactos">Contactos</a>';
      } else {
        // Mostrar enlaces para usuarios no autenticados
        echo '<a href="../index.php" title="Inicio">Inicio</a>';
        echo '<a href="pagina1.php" title="Sobre">Sobre</a>';
        echo '<a href="pagina2.php" title="Productos">Productos</a>';
        echo '<a href="pagina3.php" title="Reseñas">Reseñas</a>';
        echo '<a href="pagina4.php" title="Contactos">Contactos</a>';
      }
      ?>
    </nav>
    <div class="icons">
    <?php
    // Verificar si el usuario está autenticado
    if (!isset($_SESSION['usuario'])) {
        // Si el usuario no está autenticado, mostrar el icono de inicio de sesión
        echo '<a href="../RegistroSession/Login_y_register.php" title="Login" class="fa-regular fa-address-card"></a>';
    }
    ?>
    <?php
    // Verificar si el usuario está autenticado
    if (isset($_SESSION['usuario'])) {
        // Si el usuario está autenticado, mostrar otros íconos
        echo '<a href="carrito.php" class="fas fa-shopping-cart" id="cart-icon">';
        echo '<a href="Perfil.php" title="Perfil" class="fas fa-user"></a>';
        echo '<a href="../RegistroSession/php/cerrar_sesion.php" title="Cerrar Sesión" class="fa-solid fa-door-open"></a>';
    ?>
</div>
  <?php
      }
  ?>    
  </header>
