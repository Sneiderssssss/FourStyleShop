<?php
session_start();

include 'conexion_be.php';

// Obtener datos del formulario
$correo = $_POST['EmaCli'] ?? '';
$contrasena = $_POST['Cont'] ?? '';

// Consultar la base de datos para validar el inicio de sesión
$query = "SELECT idCli, NomCliComp, idRol FROM clientes WHERE EmaCli=? AND Cont=?";
$stmt = mysqli_prepare($conexion, $query);
mysqli_stmt_bind_param($stmt, 'ss', $correo, $contrasena);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    $usuario = mysqli_fetch_assoc($result);
    $_SESSION['usuario'] = $correo;

    // Obtener el nombre de usuario de la consulta a la base de datos
    $nombre_usuario = $usuario['NomCliComp']; // Ajusta esto según la estructura de tu base de datos

    // Establecer el nombre de usuario en la sesión
    $_SESSION['nombre_usuario'] = $nombre_usuario;
    
    // Obtener el rol del usuario
    $idRol = $usuario['idRol'];

    // Verificar el rol del usuario
    if ($idRol == 1) { // Si es un vendedor (superusuario)
        $_SESSION['superusuario'] = true;
        header("Location: superusuario.php");
        exit;
    } else if ($idRol == 2) { // Si es un administrador
        $_SESSION['administrador'] = true;
        header("Location: ../../Inicio de login/admin/panel_admin.php ");
        exit;
    } else { // Si es un usuario normal
        header("Location: ../../index.php");
        exit;
    }
} else {
    // Redireccionar si las credenciales son incorrectas
    header("Location: ../Login_y_register.php?error=credenciales_incorrectas");
    exit;
}
?>