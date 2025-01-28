<?php
session_start();
session_unset(); // Elimina todas las variables de sesión
session_destroy(); // Destruye la sesión
//Prueba no visible al usuario
echo json_encode([
    "success" => true,
    "message" => "Sesión cerrada correctamente."
]);
header("Location: ../../Vistas/index.php");
exit();
?>