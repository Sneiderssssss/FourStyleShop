<?php
include '../conexion/conexion_be.php'; // Incluir archivo de conexión a la base de datos
include 'header/headerP.php';
?>

    <section class="products" id="products">
        <h1 class="heading">Últimos <span>Productos</span></h1>
        <div class="box-container">
            <!-- Aquí irán los productos cargados desde la base de datos -->
            <?php
            // Consulta SQL para obtener todos los productos
            $sql = "SELECT * FROM productos";
            $resultado = $conexion->query($sql);

            // Verificar si hay productos
            if ($resultado->num_rows > 0) {
                // Iterar sobre cada fila de resultado
                while ($fila = $resultado->fetch_assoc()) {
                    // Mostrar información del producto en un div
                    echo '<div class="box">';
                    if (!empty($fila['descu'])) {
                        echo '<span class="discount">-' . $fila['descu'] . '%</span>'; // Mostrar descuento si hay
                    }
                    echo '<div class="image">';
                    echo '<a href="detalles.php?idPro=' . $fila['idPro'] . '"><img src="../RegistroSession/php/' . $fila['imagen'] . '" alt="" ></a>';
                    echo '<div class="icons">';
                    echo '<a href="#" class="fas fa-heart"></a>';
                    echo '<a href="#" class="cart-btn">Añadir al carrito</a>'; // Cambiado de cart-bth a cart-btn
                    echo '<a href="#" class="fas fa-share"></a>';
                    echo '</div>';
                    echo '</div>';
                    echo '<div class="content">';
                    echo '<h3>' . $fila['NomPro'] . '</h3>'; // Mostrar nombre del producto
                    echo '<div class="price">$' . number_format($fila['PrePro'], 2) . '</div>'; // Mostrar precios
                    echo '<label for="quantity_' . $fila['idPro'] . '">Cantidad:</label>';
                    echo '<select name="quantity_' . $fila['idPro'] . '" id="quantity_' . $fila['idPro'] . '">';
                    for ($i = 1; $i <= $fila['StoPro']; $i++) {
                        echo '<option value="' . $i . '">' . $i . '</option>';
                    }
                    echo '</select>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                // Mostrar mensaje si no hay productos
                echo '<p>No se encontraron productos.</p>';
            }

            // Cerrar conexión a la base de datos
            $conexion->close();
            ?>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addToCartButtons = document.querySelectorAll('.cart-btn');

            addToCartButtons.forEach(button => {
                button.addEventListener('click', addToCart);
            });

            function addToCart(event) {
                const product = event.target.closest('.box');
                const productName = product.querySelector('.content h3').innerText;
                const productPrice = parseFloat(product.querySelector('.content .price').innerText.replace('$', '').replace(',', ''));
                const productId = product.querySelector('.content select').id.split('_')[1];
                const productQuantity = document.getElementById('quantity_' + productId).value;

                // Realizar una solicitud AJAX para agregar al carrito
                const xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        // Puedes manejar la respuesta aquí si es necesario
                    }
                };
                xhttp.open("POST", "Producto/agregar_al_carrito.php", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send("nombre=" + productName + "&precio=" + productPrice + "&cantidad=" + productQuantity);
            }
        });

        document.getElementById("buscarIcono").addEventListener("click", realizarBusqueda);
        document.getElementById("buscarInput").addEventListener("input", realizarBusqueda);

        function realizarBusqueda() {
            var inputText = document.getElementById("buscarInput").value.trim();
            if (inputText !== "") {
                // Realizar una solicitud AJAX a un script PHP para buscar en la base de datos
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("resultadosBusqueda").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "buscar.php?q=" + inputText, true);
                xmlhttp.send();
            } else {
                document.getElementById("resultadosBusqueda").innerHTML = "";
            }
        }
    </script>
    <script src="jp/carrito.js" type="module"></script>
</body>

</html>