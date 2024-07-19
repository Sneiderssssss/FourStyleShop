<?php
include 'conexion_be.php';
session_start();

function insertarProducto($conexion)
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Verificar si se han enviado los campos del formulario
        if (isset($_POST['idProducto'],$_POST['nombre'], $_POST['descripcion'], $_POST['descuento'], $_POST['precio'], $_POST['cantidad'], $_POST['talla'], $_FILES['imagen'])) {
            // Validar los datos recibidos
            $idProducto = validarEntrada($_POST['idProducto']);
            $nombre = validarEntrada($_POST['nombre']);
            $descripcion = validarEntrada($_POST['descripcion']);
            $descuento = validarEntrada($_POST['descuento']);
            $precio = validarEntrada($_POST['precio']);
            $cantidad = validarEntrada($_POST['cantidad']);
            $talla = validarEntrada($_POST['talla']);

            // Obtener el archivo de imagen
            $imagen = $_FILES['imagen'];
            if ($imagen['error'] === UPLOAD_ERR_OK) {
                $nombre_imagen = $imagen['name'];
                $imagen_temporal = $imagen['tmp_name'];
                $ruta_imagen = "fotos/" . $nombre_imagen; // Ruta relativa a la carpeta del proyecto

                // Mover la imagen a la carpeta de destino
                move_uploaded_file($imagen_temporal, $ruta_imagen);

                // Preparar la consulta SQL para insertar el nuevo producto
                $sql = "INSERT INTO productos ( idProducto, NomPro, DesPro, descu, PrePro, StoPro, TalPro, imagen) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

                // Preparar la consulta
                $stmt = $conexion->prepare($sql);

                // Vincular los parámetros
                $stmt->bind_param("ssdidsss",$idProducto, $nombre, $descripcion, $descuento, $precio, $cantidad, $talla, $ruta_imagen);

                // Ejecutar la consulta
                if ($stmt->execute()) {
                    return "<p class='success'>El producto se agregó correctamente.</p>";
                } else {
                    return "<p class='error'>Error al agregar el producto.</p>";
                }
            } else {
                return "<p class='error'>Error al subir la imagen.</p>";
            }
        } else {
            return "<p class='error'>Todos los campos son requeridos.</p>";
        }
    }
}

function validarEntrada($dato)
{
    // Realizar las validaciones necesarias aquí, como filtrar caracteres especiales, etc.
    return htmlspecialchars($dato);
}

// Insertar el producto y obtener el mensaje de resultado
$resultado = insertarProducto($conexion);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Producto</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
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
        <section id="agregar-producto">
            <h2>Agregar Nuevo Producto</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                    <label for="idProducto">Id del Producto:</label>
                    <input type="text" id="idProducto" name="idProducto" required>
                </div>
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>
                <div class="form-group">
                    <label for="descripcion">Descripción:</label>
                    <textarea id="descripcion" name="descripcion" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <label for="descuento">Descuento:</label>
                    <input type="number" id="descuento" name="descuento" min="0" step="1" >
                </div>
                <div class="form-group">
                    <label for="precio">Precio:</label>
                    <input type="number" id="precio" name="precio" min="0" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="cantidad">Cantidad:</label>
                    <input type="number" id="cantidad" name="cantidad" min="0" step="1" required>
                </div>
                <div class="form-group">
                    <label for="talla">Talla:</label>
                    <input type="text" id="talla" name="talla" required>
                </div>
                <div class="form-group">
                    <label for="imagen">Imagen:</label>
                    <input type="file" id="imagen" name="imagen" accept="image/*" required>
                </div>
                <button type="submit" class="button">Agregar Producto</button>
                <?php echo $resultado; ?>
            </form>
        </section>
    </div>
    <div>
        <footer>
            <div class="copyright">
                <p>&copy; 2024 StiloShop. Todos los derechos reservados por la Empresa de <a href="">ForSytale</a>.</p>
            </div>
        </footer>
    </div>
</body>

</html>