<?php 
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['navegar'])) {
    $_SESSION['carpetaname'] = $_POST['carpeta_name'];
    echo $_POST['carpeta_name'];
    $_SESSION['carpeta'] =  $_SESSION['carpeta'].'/'.$_SESSION['carpetaname'];
    
    // Validar ruta aquí antes de redirigir
    header('Location: ../../Vistas/index.php');
    exit;
}?>