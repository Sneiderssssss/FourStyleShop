document.addEventListener('DOMContentLoaded', function() {
    const addToCartButtons = document.querySelectorAll('.cart-btn');

    addToCartButtons.forEach(button => {
        button.addEventListener('click', addToCart, { once: true }); // Agregar { once: true } para escuchar solo una vez
    });

    function addToCart(event) {
        const product = event.target.closest('.box');
        const productName = product.querySelector('.content h3').innerText;
        const productPrice = parseFloat(product.querySelector('.content .price').innerText.replace('$', '').replace(',', ''));

        // Realizar una solicitud AJAX para agregar al carrito
        const xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4) {
                if (this.status == 200) {
                    // Aquí puedes manejar la respuesta si es necesario
                    console.log('Producto agregado al carrito exitosamente');
                } else {
                    console.error('Error al agregar el producto al carrito');
                }
            }
        };
        xhttp.open("POST", "Producto/agregar_al_carrito.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("nombre=" + encodeURIComponent(productName) + "&precio=" + productPrice);
    }
});

document.getElementById("buscarIcono").addEventListener("click", realizarBusqueda);
document.getElementById("buscarInput").addEventListener("input", realizarBusqueda);

function realizarBusqueda() {
    var inputText = document.getElementById("buscarInput").value.trim();
    if(inputText !== "") {
        // Realizar una solicitud AJAX a un script PHP para buscar en la base de datos
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("resultadosBusqueda").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "buscar.php?q=" + encodeURIComponent(inputText), true);
        xmlhttp.send();
    } else {
        document.getElementById("resultadosBusqueda").innerHTML = "";
    }
}
