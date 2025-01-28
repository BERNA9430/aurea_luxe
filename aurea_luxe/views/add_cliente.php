<?php
session_start();
include '../include/db.php'; // Asegúrate de que la ruta sea correcta
include '../include/auth.php'; // Asegúrate de que la ruta sea correcta

// Verificar si el usuario ha iniciado sesión
if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $dni = trim($_POST['dni']);
    $telefono = trim($_POST['telefono']);
    $email = trim($_POST['email']);
    $direccion = trim($_POST['direccion']);
    $fecha_registro = date('Y-m-d'); // Fecha actual

    // Validar que todos los campos estén completos
    if (empty($nombre) || empty($apellido) || empty($dni) || empty($telefono) || empty($email) || empty($direccion)) {
        $error = "Todos los campos son obligatorios.";
    } else {
        try {
            // Insertar el nuevo cliente en la base de datos
            $stmt = $pdo->prepare("INSERT INTO Cliente (nombre, apellido, dni, telefono, email, direccion, fecha_registro) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$nombre, $apellido, $dni, $telefono, $email, $direccion, $fecha_registro]);
            header('Location: manage_clientes.php'); // Redirigir a la página de gestión de clientes
            exit();
        } catch (PDOException $e) {
            $error = "Error al agregar cliente: " . $e->getMessage();
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
    <title>Agregar Cliente</title>
</head>
<body>
    <div class="container">
        <h1>Agregar Cliente</h1>
        <?php if (isset($error)): ?>
            <p class="error" style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="" method="POST">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" required>
            <label for="apellido">Apellido:</label>
            <input type="text" name="apellido" id="apellido" required>
            <label for="dni">DNI:</label>
            <input type="text" name="dni" id="dni" required>
            <label for="telefono">Teléfono:</label>
            <input type="text" name="telefono" id="telefono" required>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
            <label for="direccion">Dirección:</label>
            <input type="text" name="direccion" id="direccion" required>
            <button type="submit">Agregar Cliente</button>
        </form>
    </div>
</body>
</html>