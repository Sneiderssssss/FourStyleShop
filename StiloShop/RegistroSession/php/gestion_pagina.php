<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener la opción seleccionada del formulario
    $opcion = $_POST['opciones'];

    // Redirigir al usuario a la página seleccionada
    header("Location: $opcion");
    exit;
}
?>
