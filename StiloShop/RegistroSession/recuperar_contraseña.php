<?php

require '../vendor/autoload.php'; // Carga automáticamente las clases necesarias

use SendGrid\Mail\Mail;
use SendGrid\Mail\TypeException;
use SendGrid\Mail\From;

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conexión a la base de datos

    include '../conexion/conexion_be.php'; // Asegúrate de incluir tu archivo de conexión a la base de datos

    if ($conexion->connect_error) {
        echo "<script>alert('Error al conectar a la base de datos: " . $conexion->connect_error . "'); window.location.href = 'RecCont.php';</script>";
        exit();
    }

    // Obtener la dirección de correo electrónico proporcionada por el usuario
    $userEmail = $_POST['email'];

    // Verificar si el correo electrónico existe en la base de datos
    $sql = "SELECT Cont FROM clientes WHERE EmaCli='$userEmail'";
    $result = $conexion->query($sql);

    if (!$result) {
        echo "<script>alert('Error al realizar la consulta: " . $conexion->error . "'); window.location.href = 'RecCont.php';</script>";
        exit();
    }

    if ($result->num_rows == 0) {
        echo "<script>alert('No se encontró ninguna cuenta asociada a esa dirección de correo electrónico.'); window.location.href = 'RecCont.php';</script>";
        exit();
    }

    // Obtener la contraseña de la base de datos
    $row = $result->fetch_assoc();
    $password = $row['Cont'];

    // Configurar SendGrid
    $apiKey = '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'; // Reemplaza con tu propia clave API de SendGrid
    $email = new Mail();
    try {
        $email->setFrom(new From('manuelsneider13@gmail.com', 'FourStyle'));
    } catch (TypeException $e) {
        echo "<script>alert('Error al configurar el remitente del correo electrónico: " . $e->getMessage() . "'); window.location.href = 'RecCont.php';</script>";
        exit();
    }

    $email->setSubject('Recuperación de Contraseña');
    $email->addTo($userEmail);

    // Estilos CSS para el correo electrónico
    $cssStyles = "
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f2f2f2;
                margin: 0;
                padding: 0;
            }
            .container {
                max-width: 600px;
                margin: 0 auto;
                padding: 20px;
                background-color: #fff;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }
            h1 {
                color: #333;
            }
            p {
                color: #666;
                line-height: 1.6;
            }
            strong {
                color: #000;
            }
            .logo {
                display: block;
                margin: 20px auto;
                max-width: 200px;
            }
            .button {
                display: inline-block;
                padding: 10px 20px;
                background-color: #007bff;
                color: #fff;
                text-decoration: none;
                border-radius: 5px;
            }
        </style>
    ";

    // Contenido HTML del correo electrónico
    $htmlContent = "
        <div class='container'>
            <img src='imagenes/logo1.jpg' alt='Logo de StiloShop' class='logo'>
            <h1>StiloShop</h1>
            <p>Hola,</p>
            <p>Has solicitado la recuperación de tu contraseña. Aquí está tu contraseña:</p>
            <p><strong>Tu contraseña es: $password</strong></p>
            <p>Si no solicitaste esta recuperación de contraseña, por favor ignora este mensaje.</p>
            <p>Respetamos tu privacidad. Tus datos personales están seguros con nosotros.</p>
            <p>Más información sobre FourStyle en nuestro sitio web: <a href='https://www.example.com' class='button'>www.example.com</a></p>
            <br>
            <p>Saludos,</p>
            <p>El equipo de StiloShop</p>
        </div>
    ";

    // Agregar estilos CSS al contenido HTML
    $htmlContentWithStyles = $cssStyles . $htmlContent;

    // Agregar contenido HTML al correo electrónico
    $email->addContent("text/html", $htmlContentWithStyles);

    // Enviar el correo electrónico utilizando SendGrid
    $sendgrid = new \SendGrid($apiKey);
    try {
        $response = $sendgrid->send($email);
        echo "<script>alert('Se ha enviado un correo electrónico con tu contraseña.'); window.location.href = 'RecCont.php';</script>";
    } catch (TypeException $e) {
        echo "<script>alert('Error al enviar el correo electrónico: " . $e->getMessage() . "'); window.location.href = 'RecCont.php';</script>";
    }

    $conexion->close();
}   
?>
