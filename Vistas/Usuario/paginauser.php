
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
  <form method="POST" action="../Funciones/Archivos/subir.php" id="uploadForm" enctype="multipart/form-data">
    <label for="fileInput">Subir archivo:</label>
    <input type="text" name="nombre" placeholder="Nombrar archivo">
    <input type="file" id="fileInput" name="archivo">
    <input type="submit" id="uploadButton"name="subir">Subir</input>
  </form>
  

  <!-- Botón para crear carpetas -->
  <button id="createFolderButton">Crear Carpeta</button>

  <!-- Lista de archivos y carpetas -->
  <div id="fileManager">
    <h2>Archivos y Carpetas</h2>
    <ul id="fileList">
    <?php
include('../Config/db.php');

$username = $_SESSION['user_name'];

$sql = "SELECT id, name, size, date_creation, date_update 
        FROM files 
        WHERE route LIKE CONCAT('../../Public/Storage/files/', ?, '/%')";

// Preparar la consulta
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Error en la consulta: " . $conn->error);
}

// Vincular parámetro (s = string)
$stmt->bind_param("s", $username);

// Ejecutar
$stmt->execute();

// Obtener resultados
$result = $stmt->get_result();
?>

<table border="1">
    <tr>
        <th>Nro</th>
        <th>Nombre</th>
        <th>Tamaño (KB)</th>
        <th>Fecha de Creación</th>
        <th>Última Actualización</th>
    </tr>
    
    <?php
    if ($result->num_rows > 0) {
        $nro = 1;
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$nro}</td>
                <td>{$row['name']}</td>
                <td>" . number_format($row['size'] / 1024, 2) . " KB</td>
                <td>{$row['date_creation']}</td>
                <td>{$row['date_update']}</td>
            </tr>";
            $nro++;
        }
    } else {
        echo "<tr><td colspan='5'>No hay archivos disponibles</td></tr>";
    }
    ?>
</table>
<!-- Aquí se generarán dinámicamente los archivos y carpetas -->
    </ul>
  </div>

</body>
</html>