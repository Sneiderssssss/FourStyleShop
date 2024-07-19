<?php
include '../conexion_be.php';

// Verificar si se han enviado datos por el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir los datos del formulario
    $idProducto = $_POST['idProducto'];
    $NomPro = $_POST['NomPro'];
    $PrePro = $_POST['PrePro'];
    $DesPro = $_POST['DesPro'];

    // Validación de los datos recibidos
    if (empty($idProducto) || empty($NomPro) || empty($PrePro) || empty($DesPro)) {
        echo "<script>alert('Todos los campos son obligatorios.'); window.history.back();</script>";
        exit;
    }

    if (!is_numeric($PrePro)) {
        echo "<script>alert('El precio debe ser un número válido.'); window.history.back();</script>";
        exit;
    }

    // Verificar la conexión
    if (!$conexion) {
        echo "<script>alert('Error al conectar con la base de datos: " . mysqli_connect_error() . "'); window.history.back();</script>";
        exit;
    }

    // Preparar la consulta SQL para actualizar el producto en la base de datos
    $query = "UPDATE productos SET NomPro=?, PrePro=?, DesPro=? WHERE idProducto=?";
    $stmt = mysqli_prepare($conexion, $query);

    // Verificar si la preparación de la consulta fue exitosa
    if ($stmt) {
        // Vincular los parámetros
        mysqli_stmt_bind_param($stmt, "sdsi", $NomPro, $PrePro, $DesPro, $idProducto);

        // Ejecutar la consulta
        if (mysqli_stmt_execute($stmt)) {
            // Verificar si se realizó algún cambio en la tabla
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                echo "<script>alert('Producto editado correctamente.'); window.location.href = '../editar_productos.php';</script>";
            } else {
                echo "<script>alert('No se realizaron cambios en el producto.'); window.history.back();</script>";
            }
        } else {
            // La edición del producto falló
            echo "<script>alert('Error al editar el producto: " . mysqli_error($conexion) . "'); window.history.back();</script>";
        }

        // Cerrar la declaración
        mysqli_stmt_close($stmt);
    } else {
        // La preparación de la consulta falló
        echo "<script>alert('Error al preparar la consulta: " . mysqli_error($conexion) . "'); window.history.back();</script>";
    }

    // Cerrar la conexión a la base de datos
    mysqli_close($conexion);
} else {
    // Si no se enviaron datos por el formulario, redireccionar a alguna página de error
    header("Location: error.php");
    exit;
}
?>
