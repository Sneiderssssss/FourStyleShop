<?php
include 'header/header.php';
?>

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/paginas.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Carrito</title>
</head>
<br>
<br>
<br>
<section class="cart-container">
    <h2>Carrito</h2>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            </thead>
            <tbody class="cart-items"></tbody>
        </table>
    </div>
    <button class="clear-cart btn btn-danger">Limpiar Carrito</button>
    <a href="bancos.php"><button class="checkout-btn btn btn-success">Pagar</button></a>
    <style>
    .checkout-btn {
    font-size: 1rem;
    padding: 0.756rem 0.75rem;
    border-radius: 5px;
    }
    </style>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const cartItemsContainer = document.querySelector('.cart-items');
    const cartTotal = document.querySelector('.cart-total');
    const clearCartButton = document.querySelector('.clear-cart');

    function updateCartUI() {
        // Realizar una solicitud AJAX para obtener los elementos del carrito
        const xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                cartItemsContainer.innerHTML = this.responseText;
                // Calcular el total del carrito después de actualizar los elementos
                calculateCartTotal();
                // Volver a asignar eventos a los botones "Eliminar"
                assignRemoveHandlers();
            }
        };
        xhttp.open("GET", "Producto/obtener_carrito.php", true);
        xhttp.send();
    }

    // Función para asignar eventos a los botones "Eliminar"
    function assignRemoveHandlers() {
        const removeButtons = document.querySelectorAll('.remove-item');
        removeButtons.forEach(button => {
            button.addEventListener('click', removeFromCart);
        });
    }

    // Función para eliminar un artículo del carrito
    function removeFromCart(event) {
        const itemId = event.target.dataset.id;

        // Realizar una solicitud AJAX para eliminar el artículo del carrito
        const xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Volver a cargar la interfaz del carrito después de eliminar el artículo
                updateCartUI();
            }
        };
        xhttp.open("POST", "Producto/eliminar_del_carrito.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("id=" + itemId);
    }

    // Función para limpiar el carrito  
    function clearCart() {
        // Realizar una solicitud AJAX para limpiar el carrito
        const xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Volver a cargar la interfaz del carrito después de limpiarlo
                updateCartUI();
            }
        };
        xhttp.open("GET", "Producto/limpiar_carrito.php", true);
        xhttp.send();
    }

    function calculateCartTotal() {
    const items = document.querySelectorAll('.cart-item');
    let total = 0;
    items.forEach(item => {
        const price = parseFloat(item.querySelector('.precio').innerText.replace('$', ''));
        const quantity = parseInt(item.querySelector('.cantidad').innerText);
        total += price * quantity;
    });
    if (cartTotal) {
        cartTotal.innerText = "Total: $" + total.toFixed(2);
    } else {
        console.error("Elemento 'cartTotal' no encontrado.");
    }
}


    // Asignar evento al botón "Limpiar Carrito"
    clearCartButton.addEventListener('click', clearCart);

    // Llamar a la función para actualizar el carrito al cargar la página
    updateCartUI();
});



</script>

<?php
include 'footer/footer.php'
?>