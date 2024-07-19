<?php
session_start();
require '../conexion/conexion_be.php'; 

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    header("location: ../index.php");
    exit(); 
}

// Depurar la sesión
echo "Contenido de la sesión:<br>";
var_dump($_SESSION);

// Obtener el nombre de usuario de la sesión
$usuario = $_SESSION['usuario'];

// Obtener el idCli correspondiente al usuario
$query = $conexion->prepare("SELECT idCli FROM clientes WHERE NomCliComp = ?");
$query->bind_param("s", $usuario);
$query->execute();
$result = $query->get_result();
$usuario_row = $result->fetch_assoc();

// Verificar si se encontró un usuario correspondiente
if ($usuario_row) {
    $idCli = $usuario_row['idCli'];

    // Obtener el perfil del usuario usando el idCli
    $query = $conexion->prepare("SELECT * FROM perfil WHERE idUsuario = ?");
    $query->bind_param("i", $idCli);
    $query->execute();
    $result = $query->get_result();
    $perfil = $result->fetch_assoc();

    // Si no hay información de perfil, mostrar mensaje indicando que el perfil está incompleto
    if (!$perfil) {
        $perfil = array(
            'nombre' => 'Imcompleto',
            'bio' => 'Imcompleto',
            'direccion' => 'Imcompleto',
            'telefono' => 'Imcompleto',
            'trabajo' => 'Imcompleto',
            'cargo' => 'Imcompleto',
            'ubicacion' => 'Imcompleto',
            'fecha_nacimiento' => 'Imcompleto',
            'redes_sociales' => 'Imcompleto',
            'avatar' => ''
        );
    }
} else {
    // Manejar el caso en que no se encontró un usuario correspondiente
    // Por ejemplo, puedes redirigir a una página de error o mostrar un mensaje de error
    echo "Error: No se encontró el usuario correspondiente.";
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
    <link rel="stylesheet" href="css/Perfil.css">
    <link rel="stylesheet" type="text/css" href="https://necolas.github.io/normalize.css/8.0.1/normalize.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
</head>

<body>
    <div class="container">
        <h2>Editar Perfil</h2>
        <form action="update_profile.php" method="post" enctype="multipart/form-data">
            <label for="avatar">Avatar:</label>
            <input type="file" name="avatar" id="avatar">
            <label for="bio">Biografía:</label>
            <textarea name="bio" id="bio"><?php echo htmlspecialchars($perfil['bio']); ?></textarea>
            <label for="direccion">Dirección:</label>
            <input type="text" name="direccion" id="direccion" value="<?php echo htmlspecialchars($perfil['direccion']); ?>">
            <label for="telefono">Teléfono:</label>
            <input type="text" name="telefono" id="telefono" value="<?php echo htmlspecialchars($perfil['telefono']); ?>">
            <label for="trabajo">Trabaja en:</label>
            <input type="text" name="trabajo" id="trabajo" value="<?php echo htmlspecialchars($perfil['trabajo']); ?>">
            <label for="cargo">Cargo:</label>
            <input type="text" name="cargo" id="cargo" value="<?php echo htmlspecialchars($perfil['cargo']); ?>">
            <label for="ubicacion">Ubicación:</label>
            <input type="text" name="ubicacion" id="ubicacion" value="<?php echo htmlspecialchars($perfil['ubicacion']); ?>">
            <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
            <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" value="<?php echo htmlspecialchars($perfil['fecha_nacimiento']); ?>">
            <label for="redes_sociales">Redes Sociales:</label>
            <input type="text" name="redes_sociales" id="redes_sociales" value="<?php echo htmlspecialchars($perfil['redes_sociales']); ?>">

            <button type="submit">Actualizar</button>
        </form>
    </div>
</body>

</html>
