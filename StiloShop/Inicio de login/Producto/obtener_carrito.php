<?php
include '../../conexion/conexion_be.php';

$sql = "SELECT * FROM carrito_compras";
$resultado = $conexion->query($sql);
?>

<?php if ($resultado->num_rows > 0): ?>
    <table class="cart-table">
        <thead>
            <tr>
                <th>Nombre del Producto</th>
                <th class="precio">Precio</th>
                <th class="cantidad">Cantidad</th>
                <th class="total">Total</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $total_carrito = 0;
            while ($fila = $resultado->fetch_assoc()): 
                $total_producto = $fila['precio'] * $fila['cantidad'];
                $total_carrito += $total_producto;
            ?>
                <tr>
                    <td><?= $fila['nombre_producto'] ?></td>
                    <td>$<?= number_format($fila['precio'], 2) ?></td>
                    <td><?= $fila['cantidad'] ?></td>
                    <td>$<?= number_format($total_producto, 2) ?></td>
                    <td><button class="remove-item" data-id="<?= $fila['id'] ?> "
                     style="background-color: blueviolet "; >Eliminar</button></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <div class="cart-total">Total del Carrito: $<?= number_format($total_carrito, 2) ?></div>
<?php else: ?>
    <p>No se encontraron elementos en el carrito.</p>
<?php endif; ?>

<?php $conexion->close(); ?>
