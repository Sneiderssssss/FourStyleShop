<?php
header('Content-Type: application/json');
ini_set('display_errors', 0); // Suprimir todas las advertencias
error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);

require_once '../../vendor/autoload.php'; // Asegúrate de que la ruta es correcta

use Google_Client as GoogleClient;


$response = array();

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método de solicitud no válido.');
    }

    $data = json_decode(file_get_contents('php://input'), true);
    if (!isset($data['id_token'])) {
        throw new Exception('Token no proporcionado.');
    }

    $id_token = $data['id_token'];

    $client = new GoogleClient(['client_id' => '765174794594-6dgu7f1a6gcd8p57q0m5g40vgvs0ajei.apps.googleusercontent.com']);
    $payload = $client->verifyIdToken($id_token);

    if (!$payload) {
        throw new Exception('Token inválido.');
    }

    $userid = $payload['sub'];
    $email = $payload['email'];
    $name = $payload['name'];

    include '../../conexion/conexion_be.php';

    if ($conexion->connect_error) {
        throw new Exception('Error de conexión a la base de datos: ' . $conexion->connect_error);
    }

    $sql = "SELECT * FROM clientes WHERE EmaCli='$email'";
    $result = $conexion->query($sql);

    if ($result === false) {
        throw new Exception('Error en la consulta a la base de datos: ' . $conexion->error);
    }

    session_start();
    $_SESSION['usuario'] = $email;
    $_SESSION['nombre_usuario'] = $name;

    if ($result->num_rows > 0) {
        $response['success'] = true;
    } else {
        $sql = "INSERT INTO clientes (EmaCli, NomCliComp) VALUES ('$email', '$name')";
        if ($conexion->query($sql) === TRUE) {
            $response['success'] = true;
        } else {
            throw new Exception('Error al registrar el usuario: ' . $conexion->error);
        }
    }

    $conexion->close();
} catch (Exception $e) {
    $response['success'] = false;
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
?>
