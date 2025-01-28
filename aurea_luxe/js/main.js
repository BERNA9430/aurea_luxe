// Función para mostrar un mensaje de confirmación antes de eliminar un elemento
function confirmDelete(message) {
    return confirm(message);
}

// Ejemplo de uso en un enlace de eliminación
document.querySelectorAll('.delete-link').forEach(link => {
    link.addEventListener('click', function(event) {
        if (!confirmDelete('¿Estás seguro de que deseas eliminar este elemento?')) {
            event.preventDefault(); // Evita la acción si el usuario cancela
        }
    });
});