// Validación del formulario de registrar venta
document.getElementById('addSaleForm').addEventListener('submit', function(event) {
    const cantidad = document.getElementById('cantidad').value;
    const total = document.getElementById('total').value;

    if (cantidad <= 0 || total <= 0) {
        alert('La cantidad y el total deben ser mayores que cero.');
        event.preventDefault(); // Evita el envío del formulario
    }
});
