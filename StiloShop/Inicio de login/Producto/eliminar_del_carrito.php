<?php
include '../../conexion/conexion_be.php';
// Verificar si se ha enviado un ID válido
if (isset($_POST['id']) && !empty($_POST['id'])) {
    // Incluir el archivo de conexión a la base de datos
    include '../conexion_be.php';

    // Sanitizar y obtener el ID del artículo a eliminar
    $id_articulo = $_POST['id'];

    // Preparar la consulta SQL para eliminar el artículo del carrito
    $sql = "DELETE FROM carrito_compras WHERE id = $id_articulo";

    // Ejecutar la consulta SQL
    if ($conexion->query($sql) === TRUE) {
        // La eliminación fue exitosa
        echo "El artículo ha sido eliminado del carrito correctamente.";
    } else {
        // Si hubo un error al ejecutar la consulta SQL
        echo "Error al eliminar el artículo del carrito: " . $conexion->error;
    }

    // Cerrar la conexión a la base de datos
    $conexion->close();
} else {
    // Si no se proporcionó un ID válido
    echo "ID de artículo no válido.";
}
?>
