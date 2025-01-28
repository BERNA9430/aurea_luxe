<?php
session_start();
include '../include/db.php'; // Asegúrate de que la ruta sea correcta
include '../include/auth.php'; // Asegúrate de que la ruta sea correcta

// Verificar si el usuario es administrador
if (!isAdmin()) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $dni = trim($_POST['dni']);
    $cargo = trim($_POST['cargo']);
    $fecha_ingreso = $_POST['fecha_ingreso'];
    $telefono = trim($_POST['telefono']);
    $email = trim($_POST['email']);

    // Validar que todos los campos estén completos
    if (empty($nombre) || empty($apellido) || empty($dni) || empty($cargo) || empty($fecha_ingreso) || empty($telefono) || empty($email)) {
        $error = "Todos los campos son obligatorios.";
    } else {
        try {
            // Insertar el nuevo personal en la base de datos
            $stmt = $pdo->prepare("INSERT INTO Personal (nombre, apellido, dni, cargo, fecha_ingreso, telefono, email) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$nombre, $apellido, $dni, $cargo, $fecha_ingreso, $telefono, $email]);
            header('Location: manage_personal.php'); // Redirigir a la página de gestión de personal
            exit();
        } catch (PDOException $e) {
            $error = "Error al agregar personal: " . $e->getMessage();
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
    <title>Agregar Personal</title>
</head>
<body>
    <div class="container">
        <h1>Agregar Personal</h1>
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
            <label for="cargo">Cargo:</label>
            <input type="text" name="cargo" id="cargo" required>
            <label for="fecha_ingreso">Fecha de Ingreso:</label>
            <input type="date" name="fecha_ingreso" id="fecha_ingreso" required>
            <label for="telefono">Teléfono:</label>
            <input type="text" name="telefono" id="telefono" required>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
            <button type="submit">Agregar Personal</button>
        </form>
    </div>
</body>
</html>