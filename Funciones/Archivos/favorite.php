<?php
session_start();
include('../../Config/db.php');

// Verificar que los parámetros han sido recibidos
if (!isset($_POST['ruta']) || !isset($_POST['favorite'])) {
    die("Error: Datos faltantes.");
}

$route = $_POST['ruta'];
$favorito = $_POST['favorite']; // Valor será 1 (true) o 0 (false)

// Debug (opcional)
// echo "Ruta: $route - Estado favorito: " . ($favorito ? 'TRUE' : 'FALSE');

// Determinar el valor booleano
$valorBooleano = ($favorito == 'true') ? 1 : 0; // Convertir a 1/0 para MySQL

// Consultas SQL
$sql = "UPDATE files SET favorite = ? WHERE route = ?";
$sql2 = "UPDATE carpetas SET favorite = ? WHERE route = ?";

// Preparar y ejecutar la primera consulta
$stmt1 = $conn->prepare($sql);
if ($stmt1 === false) {
    die("Error en la preparación de la consulta: " . $conn->error);
}
$stmt1->bind_param("is", $valorBooleano, $route); // "i" para entero (booleano en MySQL)
if (!$stmt1->execute()) {
    die("Error al ejecutar la consulta: " . $stmt1->error);
}

// Preparar y ejecutar la segunda consulta
$stmt2 = $conn->prepare($sql2);
if ($stmt2 === false) {
    die("Error en la preparación de la consulta: " . $conn->error);
}
$stmt2->bind_param("is", $valorBooleano, $route);
if (!$stmt2->execute()) {
    die("Error al ejecutar la consulta: " . $stmt2->error);
}

// Cerrar conexiones
$stmt1->close();
$stmt2->close();
$conn->close();

header('Location: ../../Vistas/index.php');
exit; // Siempre usar exit después de header
