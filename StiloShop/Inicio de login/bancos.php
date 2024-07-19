
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
  <script src="https://www.paypal.com/sdk/js?client-id=Abzz0j8Ve5Mth2_vyg4in6jPQvhOPyh5otHKs4iicKu0lofBuR8gfySklUrfrlZ_EVS43G4B2Qu4VkKu&currency=USD"></script>
  <link rel="stylesheet" href="css/footers.css">
  <link rel="stylesheet" href="css/style.css  ">
  <title>Metodos De Pago</title>
</head>
<body>
 <header>

    <input type="checkbox" name="" id="toggler">
    <label for="toggler" class="fas fa-bars"></label>
    <div class="logo1">
      <img src="imagenes/logo3.png" alt="">
    </div>
    <a href="#" class="logo"> StiloShop<span>.</span></a>

    <nav class="navbar">
      <a href="../index.php" title="Inicio">Inicio</a>
      <a href="pagina1.php" title="Sobre">sobre</a>
      <a href="pagina2.php" title="Productos">productos</a>
      <?php
            // Verificar si el usuario está autenticado
          if (isset($_SESSION['superusuario']) && $_SESSION['superusuario'] === true) {
                // Mostrar enlace solo para el superusuario
              echo '<a href="../RegistroSession/php/superusuario.php" title="Opciones de Productos">Opciones de Productos</a>';
          }
          ?>
      <a href="pagina3.php" title="reseñas">reseñas</a>
      <a href="pagina4.php" title="Contactos">contactos</a>
    </nav>

    <div class="icons">
      <a href="../RegistroSession/Login_y_register.php" title="Login" class="fa-regular fa-address-card"></a>
      <?php
    // Verificar si el usuario está autenticado
    if (isset($_SESSION['usuario'])) {
    ?>
      <a href="Perfil.php" title="Perfil" class="fas fa-user"></a>
      <a href="../RegistroSession/php/cerrar_sesion.php" title="Cerrar Sesión" class="fa-solid fa-door-open"></a>
    </div>
    <?php
    }
    ?>



  </header>

  <div class="main-content">
    <div class="container-datos">
      <div class="content-section">
        <h3>Tus datos</h3>
      </div>
    </div>
    <div class="payment-container">
      <h2>Seleccione su Método de Pago</h2>
      <div id="paypal-button-container"></div>
      <div class="otros-metodos">
          <button class="custom-button" onclick="attemptQRCodeChange('nequi')">
              <img
                  src="imagenes/8384d9_852790a4bdb048d28891c96acf0313f3~mv2.webp"
                  alt="Nequi"
                  width="32"
                  height="32"
              />
              Nequi
          </button>
          <button class="custom-button" onclick="attemptQRCodeChange('bancolombia')">
              <img
                  src="imagenes/77.png"
                  alt="Bancolombia"
                  width="32"
                  height="32"
              />
              Bancolombia
          </button>
          <button class="custom-button" onclick="attemptQRCodeChange('davivienda')">
              <img
                  src="imagenes/davivienda-domicilio-colombia-e1651623270162.png"
                  alt="Davivienda"
                  width="32"
                  height="32"
              />
              Davivienda
          </button>
      </div>
      <!-- Contenedor para el código QR -->
      <div id="qr-container" style="display: none; text-align: center; padding-top: 10px;">
          <img id="qr-image" width="430" src="" alt="Código QR" />
          <button class="custom-button" onclick="hideQRCode()">Cancelar</button>
      </div>
  </div>
  
  <script>
      let currentPaymentMethod = null;
  
      function attemptQRCodeChange(method) {
          if (currentPaymentMethod && currentPaymentMethod !== method) {
              const userConfirmed = confirm("¿Desea cambiar su método de pago?");
              if (!userConfirmed) {
                  return; 
              }
          }
  
          showQRCode(method);
          currentPaymentMethod = method; 
      }
  
      function showQRCode(method) {
          const qrContainer = document.getElementById("qr-container");
          const qrImage = document.getElementById("qr-image");
  
          if (!qrContainer || !qrImage) {
              console.error("El contenedor de QR o la imagen no se encuentra.");
              return;
          }
  
          qrContainer.style.display = "block";
  
          switch (method) {
              case "nequi":
                  qrImage.src = "imagenes/qr_nequi.png";
                  break;
              case "bancolombia":
                  qrImage.src = "imagenes/qr-bancolombia.jpg";
                  break;
              case "davivienda":
                  qrImage.src = "   imagenes/qr-davivienda.jpg";
                  break;
              default:
                  console.error("Método de pago no reconocido.");
                  qrContainer.style.display = "none";
          }
      }
  
      function hideQRCode() {
          const qrContainer = document.getElementById("qr-container");
          if (qrContainer) {
              qrContainer.style.display = "none";
              currentPaymentMethod = null; 
              alert("¿Desea cancelar su método de pago?");
          }
      }
  </script>
  
  
          <div id="qr-container" style="display: none; text-align: center;">
            <img id="qr-image" width="430" src="" alt="Código QR" />
            <button class="custom-button" onclick="hideQRCode()">Cancelar</button>
          </div>
        </div>
        <div class="main-content">
          <div class="content-container">
            <div class="purchase-summary">
              <h2>Resumen de la compra</h2>
              <div class="cart-products"></div>
              <div class="cart-total"  >Total a pagar: $0.00</div>
              <a href="../Inicio de login/pagina2.php" class="resumen-button">Cancelar compra</a>
            </div>
                <script>
                  function displayCartContent() {
                    const cartProductsContainer =
                      document.querySelector(".cart-products");
                    const cartTotalContainer =
                      document.querySelector(".cart-total");
                    let cart = JSON.parse(localStorage.getItem("cart")) || [];
                    if (cart.length > 0) {
                      cartProductsContainer.innerHTML = "";
                      let total = 0;
                      cart.forEach((item) => {
                        const productElement = document.createElement("div");
                        productElement.innerHTML = `
            <span>Producto: ${item.name}</span>
            <span>Precio: $${item.price.toFixed(2)}</span>
          `;
                        cartProductsContainer.appendChild(productElement);
                        total += item.price;
                      });
                      cartTotalContainer.innerText = `Total: $${total.toFixed(
                        2
                      )}`;
                    } else {
                      cartProductsContainer.innerHTML =
                        "<p>El carrito está vacío.</p>";
                      cartTotalContainer.innerText = "";
                    }
                  }
                  function clearCart() {
                    localStorage.removeItem("cart");
                    displayCartContent();
                  }
                  document.addEventListener(
                    "DOMContentLoaded",
                    displayCartContent
                  );
                </script>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script>
      paypal
        .Buttons({
          style: {
            color: "blue",
            shape: "pill",
            label: "pay",
          },
          createOrder: function (data, actions) {
            const cart = JSON.parse(localStorage.getItem("cart")) || [];
            let total = cart.reduce((sum, item) => sum + item.price, 0);
            return actions.order.create({
              purchase_units: [
                {
                  amount: {
                    value: total.toFixed(2),
                  },
                },
              ],
            });
          },
          onApprove: function (data, actions) {
            return actions.order.capture().then(function (details) {
              fetch("../public/api/process-payment.php", {
                method: "POST",
                headers: {
                  "Content-Type": "application/json",
                },
                body: JSON.stringify({ orderId: "12345", amount: 100.0 }),
              }).then((response) => {
                if (response.ok) {
                  print("Pago procesado con éxito");
                } else {
                  print("Error al procesar el pago", response.statusText);
                }
              });
            });
          },
          onCancel: function (data) {
            alert("Pago cancelado");
          },
        })
        .render("#paypal-button-container");
    </script>
    <footer>
      <div class="container">
        <div class="footer-column">
          <h3>Sobre Nosotros</h3>
          <p>
            Descubre más sobre nuestra pasión por la moda y nuestro compromiso
            con la calidad y el estilo.
          </p>
        </div>
        <div class="footer-column">
          <h3>Nuestros Productos</h3>
          <p>
            Explora nuestra amplia gama de ropa para hombres, mujeres y niños,
            diseñada para satisfacer todos los estilos y ocasiones.
          </p>
        </div>
        <div class="footer-column">
          <h3>Contáctanos</h3>
          <p>
            ¿Necesitas ayuda o tienes alguna pregunta? Ponte en contacto con
            nuestro equipo de atención al cliente.
          </p>
          <p>Email: info@StiloShop.com</p>
          <p>Teléfono: +57 3127055966</p>
          <p>Dirección: La Plata</p>
        </div>
      </div>
      <div class="social-media">
        <h3>Síguenos</h3>
        <ul class="social-icons">
          <li>
            <a href="#"><i class="fab fa-facebook"></i></a>
          </li>
          <li>
            <a href="#"><i class="fab fa-twitter"></i></a>
          </li>
          <li>
            <a href="#"><i class="fab fa-instagram"></i></a>
          </li>
        </ul>
      </div>
      <div class="copyright">
        <p>&copy; 2024 StiloShop. Todos los derechos reservados.</p>
      </div>
    </footer>
  </body>
</html>
