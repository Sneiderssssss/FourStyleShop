<?php
include '../header/header.php'
?>

<?php
include '../../conexion/conexion_be.php';
// Verifica si se ha enviado el ID del comentario a editar
if(isset($_GET['id'])) {
    // Aquí deberías incluir tu lógica para recuperar los detalles del comentario con el ID proporcionado
    $id_comentario_a_editar = $_GET['id'];
    
    // Conecta a tu base de datos y ejecuta la consulta SQL para recuperar los detalles del comentario con el ID proporcionado
    // Suponiendo que $conexion es tu objeto de conexión a la base de datos
    
    $sql = "SELECT * FROM comentarios WHERE id = $id_comentario_a_editar";
    $resultado = $conexion->query($sql);
    
    if($resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        // Aquí deberías mostrar un formulario de edición con los detalles del comentario
        ?>
        <style>
      
            /* Estilo para el formulario de edición */
            form {
                width: 300px; /* Ancho del formulario */
                padding: 20px;
                background-color:  rgba(169, 79, 192, 0.05);
                border-radius: 5px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                text-align: center;
                margin-top: 100px;
                padding: 40px 0;
            }

            label {
                font-weight: bold;
            }

            input[type="text"],
            textarea {
                width: calc(100% - 20px);
                padding: 10px;
                margin-bottom: 10px;
                border: 1px solid #ccc;
                border-radius: 4px;
                box-sizing: border-box;
            }

           input[type="submit"] {
             background-color: #9d4caf;
             color: white;
             padding: 10px 20px;
             border: none;
             border-radius: 4px;
             cursor: pointer;
            }

            input[type="submit"]:hover {
                background-color: #9d4caf;
            }

            /* Estilo para los mensajes de error o éxito */
            .message {
                margin-top: 10px;
                padding: 10px;
                border-radius: 4px;
            }

            .success {
                background-color: #4CAF50;
                color: white;
            }

            .error {
                background-color: #f44336;
                color: white;
            }
        </style>
      
        <div class="container">
            <form action="editar_comentario.php?id=<?php echo $id_comentario_a_editar; ?>" method="post">
            <h2>Editar Comentario</h2><br>
                <label for="nombre">Nombre:</label><br><br>
                <input type="text" id="nombre" name="nombre" value="<?php echo $fila['nombre']; ?>"><br>
                <label for="comentario">Comentario:</label><br><br>
                <textarea id="comentario" name="comentario" rows="4" cols="50"><?php echo $fila['comentario']; ?></textarea><br>
                <input type="submit" value="Guardar Cambios">
            </form>
        </div>
        <?php
    } else {
        echo "El comentario no existe.";
    }
} else {
    // Si no se proporcionó un ID de comentario, redirecciona a la página principal
    header("Location: ../pagina3.php");
    exit();
}

// Lógica para procesar el formulario de edición cuando se envíe
if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Aquí deberías incluir tu lógica para procesar los datos del formulario de edición y actualizar el comentario en la base de datos
    $nuevo_nombre = $_POST['nombre'];
    $nuevo_comentario = $_POST['comentario'];
    
    // Ejecuta la consulta SQL para actualizar el comentario con los nuevos datos
    $sql_actualizar = "UPDATE comentarios SET nombre='$nuevo_nombre', comentario='$nuevo_comentario' WHERE id=$id_comentario_a_editar";
    if ($conexion->query($sql_actualizar) === TRUE) {
        echo "<div class='message success'>Los cambios se guardaron correctamente.</div>";
    } else {
        echo "<div class='message error'>Error al actualizar el comentario: " . $conexion->error . "</div>";
    }
    
    // Redirecciona de vuelta a la página principal después de editar el comentario
    header("Location: ../pagina3.php");
    exit();
}

// Cerrar la conexión
$conexion->close();

?>
<?php
include'../footer/footer.php'
?>


