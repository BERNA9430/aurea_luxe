<?php
include 'include/db.php'; // Conexión a la base de datos
include 'include/auth.php'; // Funciones de autenticación

// Verificar si el usuario ha iniciado sesión
if (!isLoggedIn()) {
    header('Location: login.php'); // Redirigir a la página de inicio de sesión si no está autenticado
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>Inicio - Gestión de Información</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Bienvenido a la Gestión de Información</h1>
        <p>Hola, <?php echo $_SESSION['username']; ?>. Has iniciado sesión como <?php echo $_SESSION['role']; ?>.</p>
        
        <!-- Barra de navegación -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">Gestión</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="views/manage_users.php">Gestión de Usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="views/manage_personal.php">Gestión de Personal</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="views/manage_products.php">Gestión de Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="views/manage_ventas.php">Gestión de Ventas</a>
                    </li>
                </ul>
            </div>
        </nav>

        <a href="logout.php" class="btn btn-danger">Cerrar sesión</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>