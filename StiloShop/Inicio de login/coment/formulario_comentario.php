<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Pagina 2</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='../css/pagina.css'>
    <script src="../jp/validacion.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body>
    <header>

        <input type="checkbox" name="" id="toggler">
        <label for="toggler" class="fas fa-bars"></label>
        <a href="#" class="logo"> StiloShop<span>.</span></a>
        <nav class="navbar">
            <a href="../../index.php">Inicio</a>
            <a href="../pagina1.php">Sobre</a>
            <a href="../pagina2.php">Productos</a>
            <a href="../pagina3.php">Reseñas</a>
            <a href="../pagina4.php">Contacto</a>
        </nav>

        <div class="icons">
            <a href="#" class="fas fa-heart"></a>
            <a href="#" class="fas fa-shopping-cart"></a>
            <a href="../Ultimo/Index.html" class="fas fa-user"></a>
        </div>
    </header>


    <section>
        <!-- Formulario para que otros usuarios dejen comentario -->
        <form action="procesar_comen.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="dato" value="insert_archivo">
            <h2>Formulario de Comentarios</h2>
            <label for="nombre">Nombre:</label><br>
            <input type="text" id="nombre" name="nombre"><br><br>
            <label for="imagen">Imagen:</label><br>
            <input type="file" id="imagen" name="imagen" accept="image/*"><br><br>
            <label for="comentario">Comentario:</label><br>
            <textarea id="comentario" name="comentario" rows="4" cols="50"></textarea><br>
            <label for="fecha">Fecha:</label>
            <input type="date" id="fecha" name="fecha"><br><br>
            <label for="estadoemocional">Estado Emocional:</label>
            <select id="estadoemocional" name="estadoemocional">
                <option value="feliz">&#9733; Feliz</option>
                <option value="triste">Triste</option>
                <option value="enojado">Enojado</option>
                <option value="emocionado">Emocionado</option>
            </select><br><br>
            <input type="submit" value="Enviar Comentario">
        </form>


    
        <?php
include '../footer/footer.php'
?>