<?php
include 'conexion_be.php';

// Obtener los datos del formulario
$nombreCompleto = $_POST['NomCliComp'];
$documento = $_POST['docCli'];
$correo = $_POST['EmaCli'];
$fecha = $_POST['FecCli'];
$contrasena = $_POST['Cont'];
$direccion = $_POST['Direccion']; // Nuevo campo para la dirección

// Preparar la consulta SQL para insertar un nuevo cliente
$query = "INSERT INTO clientes (NomCliComp, docCli, FecCli, EmaCli, Cont, DirecUser) 
VALUES ('$nombreCompleto','$documento','$fecha','$correo','$contrasena','$direccion')";

// Verificar si el correo ya está registrado
$verificarCorreo = mysqli_query($conexion, "SELECT * FROM clientes WHERE EmaCli='$correo'");
if (mysqli_num_rows($verificarCorreo) > 0) {
    mostrarAlerta("Este Correo ya está registrado, intenta con otro diferente");
}

// Verificar si el nombre ya está registrado
$verificarNombre = mysqli_query($conexion, "SELECT * FROM clientes WHERE NomCliComp='$nombreCompleto'");
if (mysqli_num_rows($verificarNombre) > 0) {
    mostrarAlerta("Este Nombre ya está registrado, intenta con otro diferente");
}

// Verificar si el documento ya está registrado
$verificarDoc = mysqli_query($conexion, "SELECT * FROM clientes WHERE docCli='$documento'");
if (mysqli_num_rows($verificarDoc) > 0) {
    mostrarAlerta("Este Documento ya está registrado, intenta con otro diferente");
}

// Ejecutar la inserción si no hay problemas
$ejecutar = mysqli_query($conexion, $query);
if ($ejecutar) {
    mostrarAlerta("Registro exitoso");
}

// Función para mostrar una alerta y redirigir al usuario
function mostrarAlerta($mensaje) {
    echo "<script>
            alert('$mensaje');
            window.location = '../Login_y_register.php';
          </script>";
    exit();
}
?>
