<?php
try {
    $conexion = mysqli_connect("localhost", "root", "", "base_de_datos");

    if (!$conexion) {
        throw new mysqli_sql_exception('No se ha podido conectar a la Base de Datos: ' . mysqli_connect_error());
    }

    // Si llega hasta aquí, la conexión se estableció correctamente
    // echo 'Conectado exitosamente a la Base de Datos';
} catch (mysqli_sql_exception $e) {
    echo 'Error: ' . $e->getMessage();
}   
?>
