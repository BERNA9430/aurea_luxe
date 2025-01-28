// Validación del formulario de agregar producto
document.getElementById('addProductForm').addEventListener('submit', function(event) {
    const nombre = document.getElementById('nombre').value;
    const precio = document.getElementById('precio').value;

    if (nombre.trim() === '' || precio.trim() === '') {
        alert('Por favor, completa todos los campos.');
        event.preventDefault(); // Evita el envío del formulario
    }
});