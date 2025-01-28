// Validación del formulario de agregar usuario
document.getElementById('addUser Form').addEventListener('submit', function(event) {
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    if (username.trim() === '' || password.trim() === '') {
        alert('Por favor, completa todos los campos.');
        event.preventDefault(); // Evita el envío del formulario
    }
});