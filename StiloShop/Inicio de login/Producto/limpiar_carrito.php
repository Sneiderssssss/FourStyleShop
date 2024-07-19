<?php
// Incluir archivo de conexión a la base de datos
include '../../conexion/conexion_be.php';

// Preparar la consulta SQL para limpiar el carrito (eliminar todos los registros)
$sql = "DELETE FROM carrito_compras";

// Ejecutar la consulta SQL
if ($conexion->query($sql) === TRUE) {
    // Si la operación se realizó correctamente, devolver una respuesta exitosa
    echo "El carrito ha sido limpiado correctamente.";
} else {
    // Si hubo un error al ejecutar la consulta SQL, devolver un mensaje de error
    echo "Error al limpiar el carrito: " . $conexion->error;
}

// Cerrar la conexión a la base de datos
$conexion->close();
?>
