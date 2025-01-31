<?php 
session_start();
include('../../Config/db.php');
$tipo = $_POST['tipo'];
$route = $_POST['ruta'];
if ($tipo == 'Archivo') {
    // Eliminar archivo de la base de datos
    $stmt1 = $conn->prepare("DELETE FROM files WHERE route = ?");
    $stmt1->bind_param("s", $route);
    $stmt1->execute();

    // Eliminar archivo físicamente (en el sistema de archivos)
    if (file_exists($route)) {
        unlink($route);  // Elimina el archivo
    }

    $stmt1->close();
    echo "Archivo eliminado correctamente.";
} elseif ($tipo == 'Carpeta') {
    // Eliminar carpeta de la base de datos
    $stmt2 = $conn->prepare("DELETE FROM carpetas WHERE route = ?");
    $stmt2->bind_param("s", $route);
    $stmt2->execute();

    // Eliminar carpeta físicamente (en el sistema de archivos)
    if (is_dir($route)) {
        // Eliminar todos los archivos dentro de la carpeta (recursivamente)
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($route, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($files as $fileinfo) {
            $todo = $fileinfo->getRealPath();
            if ($fileinfo->isDir()) {
                rmdir($todo);  // Elimina la carpeta
            } else {
                unlink($todo);  // Elimina el archivo
            }
        }

        // Ahora eliminar la carpeta en sí
        rmdir($route);
    }

    $stmt2->close();
    echo "Carpeta eliminada correctamente.";
}
header('Location: ../../Vistas/index.php');
$conn->close();

?>

?>