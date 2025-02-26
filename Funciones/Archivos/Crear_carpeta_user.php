<?php
function crear_carpeta_user($usuario)
{
    // Ruta base donde se crearán las carpetas
    $rutaBase = "../../Public/Storage/files";
    $rutaCompleta = $rutaBase . "/" . $usuario;

    // Crear la carpeta si no existe
    if (!file_exists($rutaCompleta)) {
        if (mkdir($rutaCompleta, 0777, true)) {
            return true; // Carpeta creada exitosamente
        } else {
            return false; // Error al crear la carpeta
        }
    }
    return true; // La carpeta ya existe, no es necesario crearla
}
