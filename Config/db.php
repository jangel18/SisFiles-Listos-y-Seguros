<?php
// Configuración de la base de datos
$servername = "localhost"; // El servidor donde está la base de datos (por defecto es localhost)
$username = "root"; // Tu nombre de usuario de la base de datos (por defecto es 'root' en XAMPP)
$password = ""; // Tu contraseña de la base de datos (por defecto está vacía en XAMPP)
$dbname = "sisfiles"; // El nombre de tu base de datos

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);
// Comprobar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error); // Si hay un error en la conexión, lo muestra
}
?>