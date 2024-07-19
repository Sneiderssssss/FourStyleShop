<?php
include '../conexion/conexion_be.php'; // Incluir archivo de conexión a la base de datos

// Obtener el id del producto desde la URL
$product_id = isset($_GET['idPro']) ? intval($_GET['idPro']) : 0;

// Consulta SQL para obtener los detalles del producto
$sql = "SELECT * FROM productos WHERE idPro = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param('i', $product_id);
$stmt->execute();
$resultado = $stmt->get_result();
$product = $resultado->fetch_assoc();

// Verificar si se encontró el producto
if (!$product) {
    echo "Producto no encontrado.";
    exit;
}
?>

<?php
include 'header/header.php'
?>
<br>
<br>
<br>
<br>
<br>

<div class="container">
    <div class="product-image">
        <img src="../RegistroSession/php/<?php echo $product['imagen']; ?>" alt="<?php echo htmlspecialchars($product['NomPro']); ?>">
    </div>
    <div class="content">
        <div class="text-right">
            <p class="camisa"><?php echo htmlspecialchars($product['NomPro']); ?></p>
        </div>
        <div class="image-and-info">
            <div class="product-info">
                <div class="product-price">
                    <p>Precio: $<?php echo number_format($product['PrePro'], 2); ?></p>
                </div>

                <!-- Calificaciones con estrellas -->
                <div class="product-ratings">
                    <span class="product-stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </span>
                    <p>Calificación: 4.5/5</p>
                </div>

                <!-- Información de envío con detalles adicionales -->
                <div class="product-shipping">
                    <p>Envío: A todo el país</p>
                    <p class="shipping-details">Entrega estimada entre 3 y 7 días hábiles.</p>
                    <p class="shipping-details">Costos de envío variables según ubicación.</p>
                </div>

                <!-- Botones para seleccionar la talla -->
                <div class="product-sizes">
                    <button class="size-button" data-talla="S">S</button>
                    <button class="size-button" data-talla="M">M</button>
                    <button class="size-button" data-talla="L">L</button>
                    <button class="size-button" data-talla="XL">XL</button>
                </div>

                <!-- Campo para seleccionar la cantidad -->
                <div class="product-quantity">
                    <label for="cantidad">Cantidad:</label>
                    <input type="number" class="quantity-input" id="cantidad" name="cantidad" min="1" max="10" value="1">
                </div>
                <div>
                    <?php
                    echo '<a href="#" class="cart-btn">Añadir al carrito</a>'; // Cambiado de cart-bth a cart-btn
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include 'footer/footer.php'
?>

<?php
// Cerrar conexión a la base de datos
$stmt->close();
$conexion->close();
?>
