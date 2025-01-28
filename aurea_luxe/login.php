<?php
include 'include/db.php'; // Conexión a la base de datos
include 'include/auth.php'; // Funciones de autenticación

// Verificar si el usuario ya está autenticado
if (isLoggedIn()) {
    header('Location: index.php'); // Redirigir a la página principal si ya está autenticado
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Consultar la base de datos para verificar las credenciales
    $stmt = $pdo->prepare("SELECT u.id_usuario, u.password, p.id_personal FROM Usuario u JOIN Personal p ON u.id_personal = p.id_personal WHERE u.username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Obtener el rol del usuario
        $stmtRole = $pdo->prepare("SELECT r.nombre AS rol FROM Usuario_Rol ur JOIN Rol r ON ur.id_rol = r.id_rol WHERE ur.id_usuario = ?");
        $stmtRole->execute([$user['id_usuario']]);
        $role = $stmtRole->fetch(PDO::FETCH_ASSOC);

        // Almacenar información del usuario en la sesión
        $_SESSION['user_id'] = $user['id_usuario'];
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role['rol']; // Almacenar el rol en la sesión
        header('Location: index.php'); // Redirigir a la página principal
        exit();
    } else {
        $error = "Credenciales incorrectas.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>Iniciar Sesión</title>
</head>
<body>
    <div class="container">
        <h1>Iniciar Sesión</h1>
        <?php if (isset($error)): ?>
            <p class="error" style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="" method="POST">
            <label for="username">Nombre de usuario:</label>
            <input type="text" name="username" id="username" required>
            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password" required>
            <button type="submit">Iniciar Sesión</button>
        </form>
    </div>
</body>
</html>