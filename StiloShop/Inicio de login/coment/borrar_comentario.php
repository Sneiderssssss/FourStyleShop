<?php
include '../../conexion/conexion_be.php';

// Verifica si se ha enviado el ID del comentario a borrar
if(isset($_GET['id'])) {
    // Obtiene el ID del comentario a borrar desde la URL
    $id_comentario_a_borrar = $_GET['id'];
    
    // Prepara la consulta SQL para borrar el comentario
    $sql = "DELETE FROM comentarios WHERE id = ?";
    
    // Prepara la declaración y la ejecuta
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id_comentario_a_borrar);
    
    // Ejecuta la consulta
    $stmt->execute();

    // Cierra la declaración
    $stmt->close();
    
    // Redirecciona de vuelta a la página principal después de borrar el comentario
    header("Location: ../pagina3.php");
    exit();
} else {
    // Si no se proporcionó un ID de comentario, redirecciona a la página principal
    header("Location: ../pagina3.php");
    exit();
}
?>
