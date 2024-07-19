<?php
include'header/header.php'
?>

<section class="review" id="review">
    <h1 class="heading">
        <i class="fas fa-comment-alt"></i> Opiniones<span> de Clientes</span>
        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
    </h1>
    <div class="box-container">
    <?php
// Incluir el archivo de conexión a la base de datos
include '../conexion/conexion_be.php';

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario
    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];
    $imagen = $_POST["imagen"];
    $comentario = $_POST["comentario"];
    $fecha = date("Y-m-d"); // Obtener la fecha actual
    $estado_emocional = "Cliente Feliz"; // Supongo que este es el estado emocional predeterminado

    // Preparar la consulta SQL para insertar el comentario en la base de datos
    $sql = "INSERT INTO comentarios (nombre, correo, comentario, imagen, fecha, estadoemocional) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);

    // Vincular los parámetros y ejecutar la consulta
    $stmt->bind_param("ssssss", $nombre, $correo, $comentario, $imagen, $fecha, $estado_emocional);
    if ($stmt->execute()) {
        echo "¡Comentario insertado correctamente!";
    } else {
        echo "Error al insertar el comentario: " . $stmt->error;
    }

    // Cerrar el statement
    $stmt->close();
}

// Consulta para obtener los comentarios de la base de datos
$query = "SELECT * FROM comentarios";
$resultado = $conexion->query($query);

// Verificar si hay comentarios
if ($resultado->num_rows > 0) {
    // Mostrar los comentarios
    while ($fila = $resultado->fetch_assoc()) {
        echo '<div class="tax">';
        echo '<div class="stars">';
        
        // Lógica para determinar cuántas estrellas mostrar
        $numEstrellas = 0;
        switch ($fila['estadoemocional']) {
            case "feliz":
                $numEstrellas = 5;
                break;
            case "triste":
                $numEstrellas = 1;
                break;
            case "enojado":
                $numEstrellas = 2;
                break;
            case "emocionado":
                $numEstrellas = 4;
                break;
            default:
                $numEstrellas = 0;
        }
        
        // Mostrar las estrellas
        for ($i = 0; $i < $numEstrellas; $i++) {
            echo '&#9733;'; // Mostrar una estrella
        }
        
        echo '</div>';
        echo '<div class="user">';
        echo '<img src="fotos/' . $fila['imagen'] . '" alt="">';
        echo '<div class="user-info">';
        echo '<h3>' . $fila['nombre'] . '</h3>';
        echo '<p>' . $fila['comentario'] . '</p>';
         echo '<p>' . $fila['fecha'] . '</p>';
        echo '<p>' . $fila['estadoemocional'] . '</p>';
        
        // Enlace para borrar el comentario
        echo '<a href="coment/borrar_comentario.php?id=' . $fila['id'] . '">Borrar</a>';
        
        // Enlace para editar el comentario
        echo '<a href="coment/editar_comentario.php?id=' . $fila['id'] . '">Editar</a>';
        
        echo '</div></div>';
        echo '<span class="fas fa-quote-right"></span></div>';
    }
} else {
    echo "No hay comentarios aún.";
}


// Cerrar la conexión
$conexion->close();
?>
            <a href="coment/formulario_comentario.php" class="btn btn-dejar-comentario">Deja tu comentario</a>    
             
        </div>
    </div>
</section>


<?php
include 'footer/footer.php'
?>