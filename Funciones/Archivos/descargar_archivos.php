<?php 

$file = $_POST['route'] ?? '';
$tipo = $_POST['tipo'] ?? '';

if (!$file || !$tipo) {
    die("Faltan datos.");
}

// Validar la ruta para evitar accesos no autorizados
$file = realpath($file);
$baseDir = realpath("../../Storage"); // Directorio base permitido

if (!$file || strpos($file, $baseDir) !== 0) {
    die("Acceso no permitido.");
}

if (!file_exists($file)) {
    die("El archivo o carpeta no existe.");
}

if ($tipo == 'Archivo') {
    // Detectar tipo MIME dinámicamente
    $mimeType = mime_content_type($file);

    header('Content-Description: File Transfer');
    header('Content-Type: ' . $mimeType);
    header('Content-Disposition: attachment; filename="' . basename($file) . '"');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    exit;
} 
elseif ($tipo == 'Carpeta') {
    $zip = new ZipArchive();
    $zipname = "files_selected.zip";

    if ($zip->open($zipname, ZipArchive::CREATE) !== TRUE) {
        die("No se pudo crear el archivo ZIP.");
    }

    // Función recursiva para agregar archivos y carpetas al ZIP
    function agregarCarpetaAlZip($zip, $folder, $relativePath = '') {
        $files = array_diff(scandir($folder), array('.', '..'));

        foreach ($files as $fileunit) {
            $path = $folder . DIRECTORY_SEPARATOR . $fileunit;
            $localPath = $relativePath . DIRECTORY_SEPARATOR . $fileunit;

            if (is_dir($path)) {
                $zip->addEmptyDir($localPath); // Agregar carpeta vacía
                agregarCarpetaAlZip($zip, $path, $localPath); // Llamado recursivo
            } else {
                $zip->addFile($path, $localPath); // Agregar archivo
            }
        }
    }

    agregarCarpetaAlZip($zip, $file, basename($file));

    $zip->close();

    if (!file_exists($zipname)) {
        die("Error al crear el ZIP.");
    }

    // Descargar el archivo ZIP
    header('Content-Description: File Transfer');
    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="' . $zipname . '"');
    header('Content-Length: ' . filesize($zipname));
    header("Pragma: no-cache");
    header("Expires: 0");
    readfile($zipname);
    flush(); // Asegurar que se envió antes de eliminar

    unlink($zipname); // Eliminar el ZIP después de descargarlo
    exit;
}

?>
