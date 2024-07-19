<?php
include '../../conexion/conexion_be.php'; // Asegúrate de incluir el archivo conectar.php correctamente con el punto y coma al final.

// Verifica si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoge los datos del formulario, verificando si las claves existen
    $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : "";
    $comentario = isset($_POST["comentario"]) ? $_POST["comentario"] : "";
    $fecha = isset($_POST["fecha"]) ? $_POST["fecha"] : "";
    $estadoemocional = isset($_POST["estadoemocional"]) ? $_POST["estadoemocional"] : "";
    
    // Verifica si se ha subido una imagen y la procesa
    if(isset($_FILES['imagen'])) {
        $imagen = $_FILES['imagen'];
        $nombre_imagen = $imagen['name'];
        $imagen_temporal = $imagen['tmp_name'];
        $ruta_imagen = "../fotos/" . $nombre_imagen;

        // Mueve la imagen a la carpeta de destino
        if(move_uploaded_file($imagen_temporal, $ruta_imagen)) {
            echo "Imagen subida exitosamente.";
        } else {
            echo "Error al subir la imagen.";
        }
    } else {
        echo "No se ha subido ninguna imagen.";
        $ruta_imagen = ""; // Define una ruta vacía en caso de que no se haya subido ninguna imagen.
    }


    // Preparar consulta SQL para insertar el comentario en la base de datos
    $sql = "INSERT INTO comentarios (imagen, nombre, comentario, fecha, estadoemocional) VALUES ('$ruta_imagen', '$nombre', '$comentario', '$fecha', '$estadoemocional')";

    // Ejecutar consulta
    if ($conexion->query($sql) === TRUE) {
       echo "Comentario procesado exitosamente.";
        // Redirigir al usuario a la página principal
        header("Location: ../pagina3.php");
        exit(); 
    } else {
        echo "Error al procesar el comentario: " . $conexion->error;
    }

    // Cerrar conexión
    $stmt->close();
    $conexion->close();
      
}
?>