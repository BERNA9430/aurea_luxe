<?php
session_start();
session_unset(); // Elimina todas las variables de sesión
session_destroy(); // Destruye la sesión
header('Location: login.php'); // Redirigir a la página de inicio de sesión
exit();
?>