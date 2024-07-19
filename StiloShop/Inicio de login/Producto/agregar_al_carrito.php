<?php
include '../../conexion/conexion_be.php';

//verifica si hay un producto en el carrito
if(isset($_POST['nombre']) && isset($_POST['precio']) && isset($_POST['cantidad'])) {
    $nombre_producto = $_POST['nombre'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];

    $sql_check = "SELECT id FROM carrito_compras WHERE nombre_producto = '$nombre_producto'";
    $resultado_check = $conexion->query($sql_check);

    if ($resultado_check->num_rows > 0) {
        $row = $resultado_check->fetch_assoc();
        $id = $row['id'];
        $sql_update = "UPDATE carrito_compras SET cantidad = cantidad + $cantidad WHERE id = $id";
        if ($conexion->query($sql_update) === TRUE) {
            echo "<script>alert('Cantidad actualizada en el carrito.'); window.location.href = 'agregar_producto.php';</script>";
        } else {
            echo "<script>alert('Error al actualizar la cantidad en el carrito: " . $conexion->error . "');</script>";
        }
    } else {
        $sql_insert = "INSERT INTO carrito_compras (nombre_producto, precio, cantidad) VALUES ('$nombre_producto', '$precio', '$cantidad')";
        if ($conexion->query($sql_insert) === TRUE) {
            echo "<script>alert('Producto agregado al carrito con éxito.'); window.location.href = 'agregar_producto.php';</script>";
        } else {
            echo "<script>alert('Error al agregar el producto al carrito: " . $conexion->error . "');</script>";
        }
    }
    $conexion->close();
}
?>
