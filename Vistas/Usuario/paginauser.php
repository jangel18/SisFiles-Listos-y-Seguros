
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
</head>
<body>
    <h1>Hola <?php echo $_SESSION['user_name']; ?>, este es el inicio de sesion</h1>
    <a href="../../Funciones/Sesion/cerrar_sesion.php">Cerrar Sesión</a>
    <form id="uploadForm">
    <label for="fileInput">Subir archivo:</label>
    <input type="file" id="fileInput" multiple>
    <button type="button" id="uploadButton">Subir</button>
  </form>

  <!-- Botón para crear carpetas -->
  <button id="createFolderButton">Crear Carpeta</button>

  <!-- Lista de archivos y carpetas -->
  <div id="fileManager">
    <h2>Archivos y Carpetas</h2>
    <ul id="fileList">
      <!-- Aquí se generarán dinámicamente los archivos y carpetas -->
    </ul>
  </div>

</body>
</html>