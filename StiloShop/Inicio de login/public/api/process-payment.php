<?php
require '../../config/database.php'; // Ajusta la ruta para que apunte a tu configuración de base de datos

// Conexión a la base de datos
$db = new Database();
$con = $db->conectar();

// Lee el cuerpo de la solicitud
$json = file_get_contents('php://input');
$datos = json_decode($json, true);

if (is_array($datos) && isset($datos['orderId'])) {
    // Supongamos que el 'orderId' y el 'amount' son parte de los datos recibidos
    $orderId = $datos['orderId'];
    $amount = $datos['amount'];

    // Inserta la información en la base de datos para simular el procesamiento del pago
    $sql = $con->prepare("INSERT INTO pagos (orderId, amount) VALUES (?, ?)");
    $sql->execute([$orderId, $amount]);

    echo json_encode(["status" => "success", "message" => "Pago procesado con éxito"]);
} else {
    echo json_encode(["status" => "error", "message" => "Datos inválidos o incompletos"]);
}
