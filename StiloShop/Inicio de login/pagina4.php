<?php
include'header/header.php'
?>
    
    <section class="contact" id="contact">
        <h1 class="heading"><span>Contactos</span></h1>
        <div class="row">
            <form action="">
                <input type="text" placeholder="Nombre" class="box">
                <input type="email" placeholder="Correo electrónico" class="box">
                <input type="number" placeholder="Número" class="box">
                <textarea name="" class="box" placeholder="Mensaje" id="" cols="30" rows="10"></textarea>
                <input type="submit" value="Enviar mensaje" class="bth">
            </form>
            <div class="image">
                <img src="imagenes/contacto.jpg" alt="">
            </div>
        </div>
    </section>

<?php
include 'footer/footer.php'
?>