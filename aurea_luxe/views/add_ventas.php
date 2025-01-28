<?php
session_start();
include '../include/db.php'; // Asegúrate de que la ruta sea correcta
include '../include/auth.php'; // Asegúrate de que la ruta sea correcta

if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_usuario = $_SESSION['user_id'];
    $id_producto = $_POST['id_producto'];
    $cantidad = $_POST['cantidad'];
    
    // Obtener el precio del producto seleccionado
    $stmt = $pdo->prepare("SELECT precio FROM Producto WHERE id_producto = ?");
    $stmt->execute([$id_producto]);
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($producto) {
        $total = $producto['precio'] * $cantidad; // Calcular el total
        $stmt = $pdo->prepare("INSERT INTO Venta (id_cliente, id_personal, fecha_venta, total_venta, metodo_pago) VALUES (?, ?, NOW(), ?, ?)");
        $stmt->execute([$id_usuario, $id_producto, $total, 'Efectivo']); // Cambia 'Efectivo' según sea necesario
        header('Location: manage_ventas.php');
        exit();
    } else {
        $error = "Producto no encontrado.";
    }
}

// Obtener la lista de productos para el formulario
$stmt = $pdo->query("SELECT * FROM Producto");
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Registrar Venta</title>
</head>
<body>
    <div class="container">
        <!-- Barra de navegación -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">Gestión</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="manage_users.php">Gestión de Usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_personal.php">Gestión de Personal</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_products.php">Gestión de Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_ventas.php">Gestión de Ventas</a>
                    </li>
                </ul>
            </div>
        </nav>

        <h1>Registrar Venta</h1>
        <?php if (isset($error)): ?>
            <p class="error" style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="" method="POST">
            <div class="form-group">
                <label for="id_producto">Producto:</label>
                <select name="id_producto" id="id_producto" class="form-control" required>
                    <?php foreach ($productos as $producto): ?>
                        <option value="<?php echo $producto['id_producto']; ?>" data-precio="<?php echo $producto['precio']; ?>"><?php echo $producto['nombre']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="cantidad">Cantidad:</label>
                <input type="number" name="cantidad" id="cantidad" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="total">Total:</label>
                <input type="text" name="total" id="total" class="form-control" readonly>
            </div>
            <button type="submit" class="btn btn-primary">Registrar Venta</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Script para calcular el total automáticamente
        document.getElementById('cantidad').addEventListener('input', function() {
            const cantidad = this.value;
            const productoSelect = document.getElementBy 'id_producto');
            const selectedOption = productoSelect.options[productoSelect.selectedIndex];
            const precio = parseFloat(selectedOption.getAttribute('data-precio')) || 0;
            const total = cantidad * precio;
            document.getElementById('total').value = total.toFixed(2);
        });
    </script>
</body>
</html>