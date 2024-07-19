document.addEventListener("DOMContentLoaded", function() {
    // Obtén todos los botones dentro de la sección de contenido
    const buttons = document.querySelectorAll('.content button');

    // Añade un event listener a cada botón para mostrar un mensaje cuando se haga clic
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            alert(`Has hecho clic en el botón: ${this.textContent}`);
        });
    });

    // Mejora de accesibilidad: enfocar el input de búsqueda al cargar la página
    const searchInput = document.querySelector('.busqueda input');
    if (searchInput) {
        searchInput.focus();
    }

    // Mejora de accesibilidad: permite la búsqueda presionando Enter
    const searchButton = document.querySelector('.busqueda button');
    searchInput.addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            searchButton.click();
        }
    });

    // Ejemplo de función para manejo de errores de autenticación con Google (debe estar conectado con el código de autenticación)
    function handleGoogleAuthError(error) {
        console.error("Error de autenticación con Google: ", error);
        alert("Ocurrió un error con la autenticación de Google. Por favor, intenta nuevamente.");
    }
});
