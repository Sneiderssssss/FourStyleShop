<?php
session_start();

// Verificar si el usuario ha iniciado sesión como administrador
if (!isset($_SESSION['administrador']) || $_SESSION['administrador'] !== true) {
    header("Location: ../../index.php");
    exit;
}

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Incluir el archivo de conexión a la base de datos
    include '../../conexion/conexion_be.php';

    $idCliente = $_POST['idCliente'];
    $idRol = $_POST['rol'];

    // Verificar que el rol existe en la tabla 'roles'
    $query_check_role = "SELECT * FROM roles WHERE idRol = ?";
    $stmt_check_role = $conexion->prepare($query_check_role);
    $stmt_check_role->bind_param('i', $idRol);
    $stmt_check_role->execute();
    $result_check_role = $stmt_check_role->get_result();

    if ($result_check_role->num_rows > 0) {
        // Si el rol existe, proceder con la actualización del cliente
        $query = "UPDATE clientes SET idRol = ? WHERE idCli = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param('ii', $idRol, $idCliente);

        if ($stmt->execute()) {
            echo '<script>alert("Rol actualizado exitosamente."); window.location.href = "panel_admin.php";</script>';
        } else {
            echo '<script>alert("Error al actualizar el rol: ' . $stmt->error . '"); window.location.href = "panel_admin.php";</script>';
        }
    } else {
        echo '<script>alert("El rol seleccionado no existe."); window.location.href = "panel_admin.php";</script>';
    }

    // Cerrar conexiones y liberar recursos
    $stmt_check_role->close();
    $stmt->close();
    $conexion->close();
}
?>
