<?php
session_start();
include '../include/db.php'; // Asegúrate de que la ruta sea correcta
include '../include/auth.php'; // Asegúrate de que la ruta sea correcta

// Obtener la lista de productos
$stmt = $pdo->query("SELECT * FROM Producto");
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Verificar si el usuario es administrador
$isAdmin = isAdmin();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Gestión de Productos</title>
</head>
<body>
    <div class="container">
        <!-- Barra de navegación -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="index.php">Gestión</a>
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

        <h1>Gestión de Productos</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Cantidad en Stock</th>
                    <?php if ($isAdmin): ?>
                        <th>Acciones</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $producto): ?>
                    <tr>
                        <td><?php echo $producto['id_producto']; ?></td>
                        <td><?php echo $producto['nombre']; ?></td>
                        <td><?php echo $producto['descripcion']; ?></td>
                        <td><?php echo number_format($producto['precio'], 2); ?></td>
                        <td><?php echo $producto['cantidad_stock']; ?></td>
                        <?php if ($isAdmin): ?>
                            <td>
                                <a href="edit_product.php?id=<?php echo $producto['id_producto']; ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="manage_products.php?delete=<?php echo $producto['id_producto']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar este producto?');">Eliminar</a>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php if ($isAdmin): ?>
            <a href="add_product.php" class="btn btn-primary">Agregar Producto</a>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>