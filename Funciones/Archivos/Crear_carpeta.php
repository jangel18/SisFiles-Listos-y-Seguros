
<?php
session_start();
include('../../Config/db.php');

if(isset($_POST['subir'])) {
    // Validar nombre de carpeta
    if(empty($_POST['nombre'])) {
        die("Error: Nombre de carpeta requerido");
    }

    $nombre_carpeta = trim($_POST['nombre']);
    
    // Sanitizar nombre (solo letras, números y guiones)
    $nombre_carpeta = preg_replace('/[^a-zA-Z0-9-_]/', '', $nombre_carpeta);
    
    $usuario_name = $_SESSION['user_name'];
    $ruta_base = $_SESSION['ruta']. '/';
    
    // Ruta completa de la nueva carpeta
    $ruta_carpeta = $ruta_base . $nombre_carpeta ;
    
    try {
        // Crear carpeta físicamente
        if(!mkdir($ruta_carpeta, 0755, true)) {
            throw new Exception("Error al crear directorio");
        }

        // Insertar en base de datos
        $stmt = $conn->prepare("INSERT INTO carpetas (carpeta, route, fecha) VALUES (?, ?, NOW())");
        $stmt->bind_param("ss", $nombre_carpeta, $ruta_carpeta);
        
        if(!$stmt->execute()) {
            // Si falla la inserción, borrar carpeta física
            rmdir($ruta_carpeta);
            throw new Exception("Error al guardar en base de datos");
        }

        echo "Carpeta creada exitosamente!";
        
    } catch(Exception $e) {
        echo "Error: " . $e->getMessage();
    }

} else {
    echo "Acceso no autorizado";
}
header("Location: ../../Vistas/index.php");
?>