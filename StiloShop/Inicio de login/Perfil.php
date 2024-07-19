<?php
session_start();
require '../conexion/conexion_be.php'; 

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    header("location: ../index.php");
    exit(); 
}

$usuario = $_SESSION['usuario'];

$query = $conexion->prepare("SELECT idCli FROM clientes WHERE NomCliComp = ?");
$query->bind_param("s", $usuario);
$query->execute();
$result = $query->get_result();

if ($result && $result->num_rows > 0) {
    $usuario_row = $result->fetch_assoc();
    $idCli = $usuario_row['idCli'];

    // Obtener el perfil del usuario usando el idCli
    $query = $conexion->prepare("SELECT * FROM perfil WHERE idUsuario = ?");
    $query->bind_param("i", $idCli);
    $query->execute();
    $result = $query->get_result();

    // Verificar si se encontró un perfil
    if ($result && $result->num_rows > 0) {
        $perfil = $result->fetch_assoc();
    } else {
        // Establecer perfil incompleto si no se encontró ningún perfil
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
    <meta name="viewport" content="width=device-width



<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="shortcut icon" href="imagenes/logo4.jpg" type="image/x-icon">
    <link rel="stylesheet" href="css/Perfil.css">
    <link rel="stylesheet" type="text/css" href="https://necolas.github.io/normalize.css/8.0.1/normalize.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
</head>

<body>
    <section class="seccion-perfil-usuario">
        <div class="perfil-usuario-header">
            <div class="perfil-usuario-portada">
                <div class="perfil-usuario-avatar">
                    <img src="<?php echo $perfil['avatar'] ? 'uploads/' . $perfil['avatar'] : 'imagenes/cara1.jpg'; ?>" alt="img-avatar">
                </div>
            </div>
        </div>
        <div class="perfil-usuario-body">
            <div class="perfil-usuario-bio">
            <?php echo isset($perfil) ? htmlspecialchars($perfil['nombre']) : ''; ?>
                <p class="texto"><?php echo htmlspecialchars($perfil['bio']); ?></p>
            </div>
            <div class="perfil-usuario-footer">
                <ul class="lista-datos">
                    <li><i class="icono fas fa-map-signs"></i> Dirección: <?php echo htmlspecialchars($perfil['direccion']); ?></li>
                    <li><i class="icono fas fa-phone-alt"></i> Teléfono: <?php echo htmlspecialchars($perfil['telefono']); ?></li>
                    <li><i class="icono fas fa-briefcase"></i> Trabaja en: <?php echo htmlspecialchars($perfil['trabajo']); ?></li>
                    <li><i class="icono fas fa-building"></i> Cargo: <?php echo htmlspecialchars($perfil['cargo']); ?></li>
                </ul>
                <ul class="lista-datos">
                    <li><i class="icono fas fa-map-marker-alt"></i> Ubicación: <?php echo htmlspecialchars($perfil['ubicacion']); ?></li>
                    <li><i class="icono fas fa-calendar-alt"></i> Fecha nacimiento: <?php echo htmlspecialchars($perfil['fecha_nacimiento']); ?></li>
                    <li><i class="icono fas fa-share-alt"></i> Redes sociales: <?php echo htmlspecialchars($perfil['redes_sociales']); ?></li>
                </ul>
            </div>
            <div class="redes-sociales">
                <a href="" class="boton-redes facebook fab fa-facebook-f"><i class="icon-facebook"></i></a>
                <a href="" class="boton-redes twitter fab fa-twitter"><i class="icon-twitter"></i></a>
                <a href="" class="boton-redes instagram fab fa-instagram"><i class="icon-instagram"></i></a>
            </div>
            <a href="editar_perfil.php">Editar perfil</a>
        </div>
    </section>
</body>

</html>
