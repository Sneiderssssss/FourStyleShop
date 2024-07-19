document.addEventListener("DOMContentLoaded", function() {
    // Obtener el formulario
    var form = document.querySelector("form");
  
    // Agregar un evento de escucha para cuando se envíe el formulario
    form.addEventListener("submit", function(event) {
      // Obtener todos los campos de entrada del formulario
      var inputs = form.querySelectorAll("input[type=text], input[type=tel], input[type=date]");
  
      // Variable para verificar si algún campo está vacío
      var camposVacios = false;
  
      // Iterar sobre cada campo de entrada
      inputs.forEach(function(input) {
        // Verificar si el campo está vacío o solo contiene espacios en blanco
        if (input.value.trim() === "") {
          // Si está vacío, establecer camposVacios en true
          camposVacios = true;
        }
      });
  
      // Si hay campos vacíos, prevenir el envío del formulario y mostrar un mensaje
      if (camposVacios) {
        alert("Por favor, complete todos los campos.");
        event.preventDefault(); // Evita que se envíe el formulario
      }
    });
  });


  