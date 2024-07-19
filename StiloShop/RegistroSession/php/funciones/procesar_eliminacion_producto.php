<?php
include '../conexion_be.php';
session_start();

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se ha proporcionado un ID y un nombre de producto
    if (isset($_POST['idProducto']) && isset($_POST['nombreProducto'])) {
        // Obtener los datos del formulario
        $idProducto = $_POST['idProducto'];
        $nombreProducto = $_POST['nombreProducto'];

        // Consultar la base de datos para eliminar el producto por ID y nombre
        $query = "DELETE FROM productos WHERE idProducto = ? AND NomPro = ?";
        
        // Preparar la declaración SQL
        $statement = mysqli_prepare($conexion, $query);
        
        // Vincular los parámetros
        mysqli_stmt_bind_param($statement, "is", $idProducto, $nombreProducto);
        
        // Ejecutar la consulta
        mysqli_stmt_execute($statement);
        
        // Verificar si se eliminó correctamente el producto
        if (mysqli_stmt_affected_rows($statement) > 0) {
            // Producto eliminado correctamente
            echo "<script>alert('El producto se ha eliminado correctamente.'); window.location.href = '../eliminar_producto.php';</script>";
        } else {
            // No se encontró ningún producto con el ID y nombre proporcionados
            echo "<script>alert('No se encontró ningún producto con el ID y nombre proporcionados.'); window.location.href = '../eliminar_producto.php';</script>";
        }
        
        // Cerrar la declaración
        mysqli_stmt_close($statement);
    } else {
        // Por favor, proporcione tanto el ID como el nombre del producto
        echo "<script>alert('Por favor, proporcione tanto el ID como el nombre del producto.'); window.location.href = '../eliminar_producto.php';</script>";
    }
}
?>
