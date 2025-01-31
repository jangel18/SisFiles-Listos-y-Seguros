<?php

session_start();
include('../../Config/db.php');

echo  "hola";
if($_POST['subir']){
    if(file_exists($_FILES['archivo']['tmp_name'])){
        echo "exito";
        $usuario_name=$_SESSION['user_name'];
        $file_size = $_FILES['archivo']['size'];
        $user_dir= $_SESSION['ruta']. '/';
        echo $user_dir;
        if(move_uploaded_file($_FILES['archivo']['tmp_name'],$user_dir . $_FILES['archivo']['name'] )){
            $route=$user_dir . $_FILES['archivo']['name'];
            $nombre_file= $_POST['nombre'];
            $type="archivo";
            $sql = $conn->query("INSERT INTO files (name,type,size,route) VALUES ('".$nombre_file."','".$type."','".$file_size."','".$route."')");
            header('Location: ../../Vistas/index.php');
        }else{echo "error";}
    }else{echo "error";}

}else{
    echo "no se a subido";
}
?>