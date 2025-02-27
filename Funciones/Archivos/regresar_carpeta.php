<?php
session_start();
$carpeta_ruta = $_SESSION['carpeta'];
$carpeta_ruta = dirname($carpeta_ruta);
$_SESSION['carpeta'] = $carpeta_ruta;
if ($_SESSION['carpeta'] == "\\") {
    $_SESSION['carpeta'] = NULL;
    $_SESSION['carpetaname'] = NULL;
}
echo $carpeta_ruta;

header('Location: ../../Vistas/index.php');
