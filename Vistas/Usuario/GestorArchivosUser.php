<?php 
session_start();

$username = $_SESSION['user_name'];

if(isset($_SESSION['carpeta'])){
$_SESSION['ruta']='../../Public/Storage/files/'.$username.$_SESSION['carpeta'];}
else{$_SESSION['ruta']='../../Public/Storage/files/'.$username.'';}
$ruta=$_SESSION['ruta'];

echo $ruta;


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles/icons/color_icons.css" />
    <link rel="stylesheet" href="styles/icons/tabla.css" />
    <!--    fontawesome  para iconos de carpetas,archivos y funcionalidades de estos  --> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    
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
  <form method="POST"action="../../Funciones/Archivos/Crear_carpeta.php">
  <input type="text" name="nombre" placeholder="Nombrar carpeta">
  <input type="submit" id="createFolderButton" name="subir">Crear Carpeta</input>
  </form>

  <!-- Lista de archivos y carpetas -->
  <div id="fileManager">
    <h2>Archivos y Carpetas</h2>
    <?php
    if(isset($_SESSION['carpeta'])){
    echo '<a href="../../Funciones/Archivos/regresar_carpeta.php">volver a la anterior carpeta</a>';
    echo  $_SESSION['carpeta'];
        }?>
    <ul id="fileList">
<?php
    include('../Config/db.php');



$sql = "SELECT id, name, size, date_creation, date_update, 'Archivo' AS tipo,favorite,route 
FROM files 
WHERE route LIKE CONCAT(?, '/%')
  AND route NOT LIKE CONCAT(?, '/%/%')

UNION ALL

SELECT id, carpeta AS name, 0 AS size, fecha AS date_creation, fecha AS date_update, 'Carpeta' AS tipo,favorite,route 
FROM carpetas  
WHERE route LIKE CONCAT(?, '/%') 
  AND route NOT LIKE CONCAT(?, '/%/%');
";

// Preparar la consulta
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Error en la consulta: " . $conn->error);
}

// Vincular parámetro (s = string)
$stmt->bind_param('ssss', $ruta, $ruta, $ruta, $ruta);

// Ejecutar
$stmt->execute();

// Obtener resultados
$result = $stmt->get_result();
?>

<table border="1" id="grid">
    <thead>
    <tr>
        <th data-type="number">Nro</th>
        <th data-type="string">Tipo</th>
        <th data-type="string">Nombre</th>
        <th data-type="number">Tamaño (KB)</th>
        <th data-type="string">Fecha de Creación</th>
        <th data-type="string">Última Actualización</th>
        <th data-type="string">Favorito</th>
        <th>Eliminar</th>
    </tr>
    </thead>
   <tbody>
   <?php
    if ($result->num_rows > 0) {
        $nro = 1;
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$nro}</td>";
                if ($row['tipo'] === 'Carpeta') {
                    echo "<td data-sort='Carpeta'><img class='icon' src='../Public/Storage/3516096.png' alt='Folder'/></td>";
                } else {
                    echo "<td data-sort='Archivo'><img class='icon2' src='../Public/Storage/304579.png' alt='File'/></td>";
                }
               
                if ($row['tipo'] === 'Carpeta') {
                    echo "<td>
                        <form method='post' action='../Funciones/Archivos/navegar.php'>
                            <input type='hidden' name='carpeta_name' value='" . htmlspecialchars($row['name']) . "'>
                            <button type='submit' name='navegar' class='btn-carpeta'>
                                " . htmlspecialchars($row['name']) . "
                            </button>
                        </form>
                    </td>";
                } else {
                    echo "<td>
                        <form method='post' action='../Funciones/Archivos/descargar_archivos.php'>
                            <input type='hidden' name='route' value='" . htmlspecialchars($row['route']) . "'>
                            <button type='submit' name='navegar' class='btn-carpeta'>
                                " . htmlspecialchars($row['name']) . "
                            </button> </form> </td>";
                }
            
                if ($row['tipo'] === 'Archivo') {
                    echo "<td>" . number_format($row['size'] / 1024, 2) . " KB</td>";
                } else {
                    echo "<td></td>";
                }
                echo "<td>{$row['date_creation']}</td>
                    <td>{$row['date_update']}</td>
                    <td>  
                        <form method='POST' action='../Funciones/Archivos/favorite.php'>";

                if ($row['favorite']) {
                    echo "<button type='submit' class='favorite' name='favorite' value='false'>
                            <input type='hidden' name='ruta' value='" . htmlspecialchars($row['route']) . "'> 
                            <i class='fa-solid fa-star' style='color: gold;'></i>
                        </button>";
                } else {
                    echo "<button type='submit' class='favorite' name='favorite' value='true'>
                            <input type='hidden' name='ruta' value='" . htmlspecialchars($row['route']) . "'> 
                            <i class='fa-regular fa-star' style='color: gray;'></i>
                        </button>";
                }

                echo "</form>
                    </td>
                    <td>
                        <form method='POST' action='../Funciones/Archivos/eliminar.php'>
                            <input type='hidden' name='tipo' value='" . htmlspecialchars($row['tipo']) . "'> 
                            <button type='submit' class='delete' name='ruta' value='" . htmlspecialchars($row['route']) . "'>
                                <i class='fa-solid fa-trash'></i>
                            </button>
                        </form>
                    </td>
                </tr>";

            $nro++;
        }
    } else {
        echo "<tr><td colspan='8'>No hay archivos disponibles</td></tr>";
    }
    ?>
    </tbody>
</table>
<script>
    let grid = document.getElementById('grid');
    let sortConfig = {
        column: null,
        direction: 'asc' // 'asc' or 'desc'
    };

    grid.onclick = function(e) {
        if (e.target.tagName !== 'TH') return;
        
        const th = e.target;
        if (!th.dataset.type) return;

        // Determinar dirección de ordenamiento
        if (sortConfig.column === th.cellIndex) {
            sortConfig.direction = sortConfig.direction === 'asc' ? 'desc' : 'asc';
        } else {
            sortConfig.column = th.cellIndex;
            sortConfig.direction = 'asc';
        }
        // Dentro del evento click, después de cambiar sortConfig:
        // Remover clases anteriores
        document.querySelectorAll('th[data-type]').forEach(th => {
        th.classList.remove('sorted-asc', 'sorted-desc');
            });

        // Agregar clase al th actual
        th.classList.add(`sorted-${sortConfig.direction}`);

        sortGrid(th.cellIndex, th.dataset.type, sortConfig.direction);
    };

    function sortGrid(colNum, type, direction) {
        const tbody = grid.querySelector('tbody');
        const rows = Array.from(tbody.rows);

        const compare = (a, b) => {
            const aCell = a.cells[colNum];
            const bCell = b.cells[colNum];
            
            // Manejar columna de Tipo
            if (colNum === 1) {
                const aVal = aCell.getAttribute('data-sort');
                const bVal = bCell.getAttribute('data-sort');
                return direction === 'asc' 
                    ? aVal.localeCompare(bVal) 
                    : bVal.localeCompare(aVal);
            }

            // Obtener valores según tipo
            let aVal, bVal;
            switch(type) {
                case 'number':
                    aVal = parseFloat(aCell.textContent) || 0;
                    bVal = parseFloat(bCell.textContent) || 0;
                    return direction === 'asc' ? aVal - bVal : bVal - aVal;
                
                case 'string':
                    aVal = aCell.textContent.trim();
                    bVal = bCell.textContent.trim();
                    return direction === 'asc' 
                        ? aVal.localeCompare(bVal) 
                        : bVal.localeCompare(aVal);
                
                default:
                    return 0;
            }
        };

        rows.sort(compare);
        tbody.append(...rows);
    }
</script>
<!-- Aquí se generarán dinámicamente los archivos y carpetas -->
    </ul>
  </div>

</body>
</html>