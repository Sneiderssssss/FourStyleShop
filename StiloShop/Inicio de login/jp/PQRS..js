
const toggleMenu = () => {
    const menu = document.querySelector('nav ul');
    menu.classList.toggle('show');
};

document.querySelector('.menu-icon').addEventListener('click', toggleMenu);


const searchInput = document.querySelector('.busqueda input');
const searchButton = document.querySelector('.busqueda button');

searchButton.addEventListener('click', () => {
    const searchTerm = searchInput.value.trim();
    if (searchTerm !== '') {
        
        alert('Realizar búsqueda de: ' + searchTerm);
    } else {
        alert('Por favor, ingrese un término de búsqueda.');
    }
});
