<?php
session_start();

// Verificar si el usuario ha iniciado sesión como administrador
if (!isset($_SESSION['administrador']) || $_SESSION['administrador'] !== true) {
    header("Location: ../../index.php");
    exit;
}

// Función para cerrar sesión
if (isset($_GET['cerrar_sesion'])) {
    // Destruir todas las variables de sesión
    $_SESSION = array();

    // Si se desea destruir la cookie, se debe enviar una cookie vacía con la fecha de caducidad pasada
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Finalmente, destruir la sesión
    session_destroy();

    // Redireccionar al usuario de vuelta al inicio o a donde desees
    header("Location: ../../index.php");
    exit;
}

// Incluir el archivo de conexión a la base de datos
include '../../conexion/conexion_be.php';

// Obtener información general de la base de datos
$query_tables = "SHOW TABLES";
$result_tables = mysqli_query($conexion, $query_tables);

$tables_info = [];
while ($table = mysqli_fetch_row($result_tables)) {
    $table_name = $table[0];
    $query_columns = "SHOW COLUMNS FROM `$table_name`"; // Corregido para usar comillas invertidas
    $result_columns = mysqli_query($conexion, $query_columns);

    $columns_info = [];
    while ($column = mysqli_fetch_assoc($result_columns)) {
        $columns_info[] = $column;
    }

    $tables_info[$table_name] = $columns_info;
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['idCliente'])) {
    $idCliente = $_POST['idCliente'];
    
    // Consulta para eliminar el cliente
    $query_eliminar_cliente = "DELETE FROM clientes WHERE idCli = '$idCliente'";
    
    // Ejecutar la consulta
    if (mysqli_query($conexion, $query_eliminar_cliente)) {
        // Éxito al eliminar el cliente
        // Puedes redirigir a una página de éxito o realizar cualquier otra acción
        // Por ejemplo, redirigir nuevamente a esta página para actualizar la tabla de clientes
        header("Location: panel_admin.php");
        exit;
    } else {
        // Error al eliminar el cliente
        // Manejar el error según sea necesario
        echo "Error al eliminar el cliente: " . mysqli_error($conexion);
    }
}
if (isset($_POST['idProducto'])) {
    $idProducto = $_POST['idProducto'];
    
    // Consulta para eliminar el producto
    $query_eliminar_producto = "DELETE FROM productos WHERE idPro = $idProducto";
    
    // Ejecutar la consulta
    mysqli_query($conexion, $query_eliminar_producto);
    
    // Redireccionar de nuevo al panel de administrador
    header("Location: panel_admin.php");
    exit;
}

// Función para eliminar un pedido
if (isset($_POST['idPedido'])) {
    $idPedido = $_POST['idPedido'];
    
    // Consulta para eliminar el pedido
    $query_eliminar_pedido = "DELETE FROM pedidos WHERE idPed = $idPedido";
    
    // Ejecutar la consulta
    mysqli_query($conexion, $query_eliminar_pedido);
    
    // Redireccionar de nuevo al panel de administrador
    header("Location: panel_admin.php");
    exit;
}

// Obtener estadísticas de la base de datos
$query_stats = "
    SELECT 
        (SELECT COUNT(*) FROM clientes) AS total_clientes,
        (SELECT COUNT(*) FROM productos) AS total_productos,
        (SELECT COUNT(*) FROM pedidos) AS total_pedidos
";
$result_stats = mysqli_query($conexion, $query_stats);
$stats = mysqli_fetch_assoc($result_stats);

// Obtener la versión de la base de datos
$query_version = "SELECT VERSION() as version";
$result_version = mysqli_query($conexion, $query_version);
$version = mysqli_fetch_assoc($result_version)['version'];

// Obtener el nombre de la base de datos actual
$query_db_name = "SELECT DATABASE() as db_name";
$result_db_name = mysqli_query($conexion, $query_db_name);
$db_name = mysqli_fetch_assoc($result_db_name)['db_name'];

// Obtener información de los clientes
$query_clientes = "SELECT clientes.*, roles.nombreRol FROM clientes LEFT JOIN roles ON clientes.idRol = roles.idRol";
$result_clientes = mysqli_query($conexion, $query_clientes);

// Obtener información de los productos
$query_productos = "SELECT * FROM productos";
$result_productos = mysqli_query($conexion, $query_productos);

// Obtener información de los pedidos
$query_pedidos = "SELECT * FROM pedidos";
$result_pedidos = mysqli_query($conexion, $query_pedidos);

// Obtener información de los usuarios para asignar roles
$query_usuarios = "SELECT clientes.idCli, clientes.NomCliComp FROM clientes";
$result_usuarios = mysqli_query($conexion, $query_usuarios);

?>



<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador</title>
    <link rel="stylesheet" href="css/panel_admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>
    <aside class="sidebar">
        <div class="logo">
            <h2>Admin Panel</h2>
        </div>
        <nav class="navigation">
    <ul>
        <li><a href="#section-informacion-general"><i class="fas fa-home"></i> Información General</a></li>
        <li><a href="#section-clientes"><i class="fas fa-users"></i> Clientes</a></li>
        <li><a href="#section-productos"><i class="fas fa-box-open"></i> Productos</a></li>
        <li><a href="#section-pedidos"><i class="fas fa-shopping-cart"></i> Pedidos</a></li>
        <li><a href="#section-roles"><i class="fas fa-user-tag"></i> Roles de Usuario</a></li>
        <li><a href="panel_admin.php?cerrar_sesion=1"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
    </ul>
</nav>


        <div class="bottom-icons">
            <a href="#informacion_general"><i class="fas fa-home"></i></a>
            <a href="#clientes"><i class="fas fa-users"></i></a>
            <a href="#productos"><i class="fas fa-box-open"></i></a>
            <a href="#pedidos"><i class="fas fa-shopping-cart"></i></a>
            <a href="#roles"><i class="fas fa-user-tag"></i></a>
        </div>
    </aside>

    <main class="content">
    <section id="section-informacion-general">
    <h2>Información General</h2>
    <h3>Información de la Base de Datos</h3>
    <ul>
        <li>Versión de la Base de Datos: <?php echo $version; ?></li>
        <li>Nombre de la Base de Datos: <?php echo $db_name; ?></li>
    </ul>
    <h3>Estadísticas Generales</h3>
    <ul>
        <li>Total Clientes: <?php echo $stats['total_clientes']; ?></li>
        <li>Total Productos: <?php echo $stats['total_productos']; ?></li>
        <li>Total Pedidos: <?php echo $stats['total_pedidos']; ?></li>
    </ul>
    <h3>Información de Stiloshop</h3>
    <ul>
        <li>Nombre del Sitio: Stiloshop</li>
        <li>Propósito: Tienda en línea de productos textiles</li>
        <li>Administrador del Sitio: FourStyle</li>
        <li>Correo de Contacto: FourStyle@gmail.com</li>
        <li>Dirección: La Plata Huila, Colombia</li>
        <li>Teléfono: 3107582784</li>
    </ul>
    <h3 class="toggle-header">Tablas y Columnas</h3>
    <?php foreach ($tables_info as $table_name => $columns) : ?>
        <h4><?php echo $table_name; ?></h4> <!-- Agregar nombre de la tabla -->
        <table id="<?php echo $table_name; ?>">
            <thead>
                <tr>
                    <th>Columna</th>
                    <th>Tipo</th>
                    <th>Nulo</th>
                    <th>Clave</th>
                    <th>Por Defecto</th>
                    <th>Extra</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($columns as $column) : ?>
                    <tr>
                        <td><?php echo $column['Field']; ?></td>
                        <td><?php echo $column['Type']; ?></td>
                        <td><?php echo $column['Null']; ?></td>
                        <td><?php echo $column['Key']; ?></td>
                        <td><?php echo $column['Default']; ?></td>
                        <td><?php echo $column['Extra']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endforeach; ?>
</section>

        <!-- Contenido de las secciones oculto por defecto -->
        <section id="section-clientes">
    <h2>Clientes</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo electrónico</th>
                <th>Rol</th>
                <th>Acción</th> <!-- Nueva columna para la acción de eliminar -->
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result_clientes)) : ?>
                <tr>
                    <td><?php echo $row['idCli']; ?></td>
                    <td><?php echo $row['NomCliComp']; ?></td>
                    <td><?php echo $row['EmaCli']; ?></td>
                    <td><?php echo $row['nombreRol']; ?></td>
                    <td>
                        <!-- Formulario para eliminar el cliente -->
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                            <!-- Input oculto para enviar el ID del cliente -->
                            <input type="hidden" name="idCliente" value="<?php echo $row['idCli']; ?>">
                            <!-- Botón para enviar el formulario -->
                            <button type="submit">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</section>


<section id="section-productos">
    <h2>Productos</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Acción</th> <!-- Nueva columna para la acción de eliminar -->
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result_productos)) : ?>
                <tr>
                    <td><?php echo $row['idPro']; ?></td>
                    <td><?php echo $row['NomPro']; ?></td>
                    <td><?php echo $row['DesPro']; ?></td>
                    <td><?php echo $row['PrePro']; ?></td>
                    <td><?php echo $row['StoPro']; ?></td>
                    <td>
                        <!-- Formulario para eliminar el producto -->
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                            <!-- Input oculto para enviar el ID del producto -->
                            <input type="hidden" name="idProducto" value="<?php echo $row['idPro']; ?>">
                            <!-- Botón para enviar el formulario -->
                            <button type="submit">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</section>

<section id="section-pedidos">
    <h2>Pedidos</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>ID del Producto</th>
                <th>Cantidad</th>
                <th>ID del Cliente</th>
                <th>Acción</th> <!-- Nueva columna para la acción de eliminar -->
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result_pedidos)) : ?>
                <tr>
                    <td><?php echo $row['idPed']; ?></td>
                    <td><?php echo $row['FecPed']; ?></td>
                    <td><?php echo $row['EstPed']; ?></td>
                    <td><?php echo $row['idProPed']; ?></td>
                    <td><?php echo $row['CanPed']; ?></td>
                    <td><?php echo $row['IdClien']; ?></td>
                    <td>
                        <!-- Formulario para eliminar el pedido -->
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                            <!-- Input oculto para enviar el ID del pedido -->
                            <input type="hidden" name="idPedido" value="<?php echo $row['idPed']; ?>">
                            <!-- Botón para enviar el formulario -->
                            <button type="submit">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</section>


        <section id="section-roles">
            <h2>Roles de Usuario</h2>
            <form action="asignar_roles.php" method="post">
                <label for="idCliente">Seleccionar Cliente:</label>
                <select name="idCliente" id="idCliente">
                    <?php mysqli_data_seek($result_usuarios, 0); ?>
                    <?php while ($row = mysqli_fetch_assoc($result_usuarios)) : ?>
                        <option value="<?php echo $row['idCli']; ?>"><?php echo $row['NomCliComp']; ?></option>
                    <?php endwhile; ?>
                </select>
                <label for="rol">Rol:</label>
                <select name="rol" id="rol">
                    <option value="3">Cliente</option>
                    <option value="1">Vendedor</option>
                    <option value="2">Administrador</option>
                </select>
                <button type="submit">Asignar Rol</button>
            </form>
        </section>

    </main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
    
</body </html>