<?php 

$file= $_POST['route'];

    if(file_exists($file)){
        
        header('Content-Description: File Transfer');
        header('Content-Type: application/pdf');    
        header('Content-Disposition: attachment; filename="'.basename($file).'"');  
        header('Content-Length:'.filesize($file));
        readfile($file);
        exit;   
    }else {
        echo "el archivo no existe";
        die;
        
    }

?>