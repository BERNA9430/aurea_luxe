<?php
session_start();
include '../includes/db.php'; // Asegúrate de que la ruta sea correcta
include '../include/auth.php'; // Asegúrate de que la ruta sea correcta

// Verificar si el usuario ha iniciado sesión
if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $nombre_empresa = trim($_POST['nombre_empresa']);
    $contacto = trim($_POST['contacto']);
    $telefono = trim($_POST['telefono']);
    $email = trim($_POST['email']);
    $direccion = trim($_POST['direccion']);

    // Validar que todos los campos estén completos
    if (empty($nombre_empresa) || empty($contacto) || empty($telefono) || empty($email) || empty($direccion)) {
        $error = "Todos los campos son obligatorios.";
    } else {
        try {
            // Insertar el nuevo proveedor en la base de datos
            $stmt = $pdo->prepare("INSERT INTO Proveedor (nombre_empresa, contacto, telefono, email, direccion) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$nombre_empresa, $contacto, $telefono, $email, $direccion]);
            header('Location: manage_proveedores.php'); // Redirigir a la página de gestión de proveedores
            exit();
        } catch (PDOException $e) {
            $error = "Error al agregar proveedor: " . $e->getMessage();
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
    <title>Agregar Proveedor</title>
</head>
<body>
    <div class="container">
        <h1>Agregar Proveedor</h1>
        <?php if (isset($error)): ?>
            <p class="error" style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="" method="POST">
            <label for="nombre_empresa">Nombre de Empresa:</label>
            <input type="text" name="nombre_empresa" id="nombre_empresa" required>
            <label for="contacto">Contacto:</label>
            <input type="text" name="contacto" id="contacto" required>
            <label for="telefono">Teléfono:</label>
            <input type="text" name="telefono" id="telefono" required>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
            <label for="direccion">Dirección:</label>
            <input type="text" name="direccion" id="direccion" required>
            <button type="submit">Agregar Proveedor</button>
        </form>
    </div>
</body>
</html>