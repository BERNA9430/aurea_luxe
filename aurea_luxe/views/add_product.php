<?php
session_start();
include '../include/db.php'; // Asegúrate de que la ruta sea correcta
include '../include/auth.php'; // Asegúrate de que la ruta sea correcta

// Verificar si el usuario ha iniciado sesión
if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

// Obtener la lista de proveedores para el formulario
$stmt = $pdo->query("SELECT * FROM Proveedor");
$proveedores = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);
    $precio = trim($_POST['precio']);
    $cantidad_stock = trim($_POST['cantidad_stock']);
    $id_proveedor = $_POST['id_proveedor'];
    $categoria = trim($_POST['categoria']);
    $material = trim($_POST['material']);
    $fecha_adquisicion = $_POST['fecha_adquisicion'];

    // Validar que todos los campos estén completos
    if (empty($nombre) || empty($descripcion) || empty($precio) || empty($cantidad_stock) || empty($id_proveedor) || empty($categoria) || empty($material) || empty($fecha_adquisicion)) {
        $error = "Todos los campos son obligatorios.";
    } else {
        try {
            // Insertar el nuevo producto en la base de datos
            $stmt = $pdo->prepare("INSERT INTO Producto (nombre, descripcion, precio, cantidad_stock, id_proveedor, categoria, material, fecha_adquisicion) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$nombre, $descripcion, $precio, $cantidad_stock, $id_proveedor, $categoria, $material, $fecha_adquisicion]);
            header('Location: manage_products.php'); // Redirigir a la página de gestión de productos
            exit();
        } catch (PDOException $e) {
            $error = "Error al agregar producto: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Agregar Producto</title>
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

        <h1>Agregar Producto</h1>
        <?php if (isset($error)): ?>
            <p class="error" style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="" method="POST">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea name="descripcion" id="descripcion" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label for="precio">Precio:</label>
                <input type="number" step="0.01" name="precio" id="precio" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="cantidad_stock">Cantidad en Stock:</label>
                <input type="number" name="cantidad_stock" id="cantidad_stock" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="id_proveedor">Proveedor:</label>
                <select name="id_proveedor" id="id_proveedor" class="form-control" required>
                    <?php foreach ($proveedores as $proveedor): ?>
                        <option value="<?php echo $proveedor['id_proveedor']; ?>"><?php echo $proveedor['nombre_empresa']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="categoria">Categoría:</label>
                <input type="text" name="categoria" id="categoria" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="material">Material:</label>
                <input type="text" name="material" id="material" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="fecha_adquisicion">Fecha de Adquisición:</label>
                <input type="date" name="fecha_adquisicion" id="fecha_adquisicion" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Agregar Producto</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>