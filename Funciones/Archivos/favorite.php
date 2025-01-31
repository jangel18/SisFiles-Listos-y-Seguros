<?php 
session_start();
include('../../Config/db.php');

$route = $_POST['ruta'];
$favorito = $_POST['favorite'];  // El valor del botón que indica si es favorito
echo "$route' a '$favorito";
// Verificar que los parámetros han sido recibidos
if (!isset($route) || !isset($favorito)) {
    die("Error: Datos faltantes.");
}

// Determinar la acción según el valor de 'favorite'
if ($favorito == 'favorite') {
    $sql = "UPDATE files SET favorite = 'favorite' WHERE route = ?";
    $sql2 = "UPDATE carpetas SET favorite = 'favorite' WHERE route = ?";
} else {
    $sql = "UPDATE files SET favorite = NULL WHERE route = ?";
    $sql2 = "UPDATE carpetas SET favorite = NULL WHERE route = ?";
}

// Preparar y ejecutar la primera consulta
$stmt1 = $conn->prepare($sql);
if ($stmt1 === false) {
    die("Error en la preparación de la consulta: " . $conn->error);
}
$stmt1->bind_param("s", $route);
if (!$stmt1->execute()) {
    die("Error al ejecutar la consulta: " . $stmt1->error);
}

// Preparar y ejecutar la segunda consulta
$stmt2 = $conn->prepare($sql2);
if ($stmt2 === false) {
    die("Error en la preparación de la consulta: " . $conn->error);
}
$stmt2->bind_param("s", $route);
if (!$stmt2->execute()) {
    die("Error al ejecutar la consulta: " . $stmt2->error);
}

// Cerrar las sentencias y la conexión
$stmt1->close();
$stmt2->close();
$conn->close();
header('Location: ../../Vistas/index.php');
echo "Estado de favorito actualizado correctamente.";

?>
