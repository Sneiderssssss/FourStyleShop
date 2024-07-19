<?php
session_start();

include '../Login y register../php/conexion_be.php';

$q = $_GET['q'];

$sql = "SELECT * FROM productos WHERE NomPro LIKE '%$q%'";
$result = mysqli_query($conexion, $sql);

// Mostrar los resultados
if (mysqli_num_rows($result) > 0) {
    // Output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        echo "<div>" . $row["nombre"] . "</div>";
    }
} else {
    echo "No se encontraron resultados";
}

// Cerrar conexión
mysqli_close($conexion);
?>
