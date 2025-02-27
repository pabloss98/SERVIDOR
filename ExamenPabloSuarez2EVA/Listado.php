<?php
session_start();

$hn = "localhost"; 
$un = "root";      
$pw = "";          
$db = "pictogramas"; 

$connection = new mysqli($hn, $un, $pw, $db);

if ($connection->connect_error) {
    die("Error de conexión: " . $connection->connect_error);
}

$query = "SELECT * FROM imagenes";
$result = $connection->query($query);

if (!$result) {
    die("Error en la consulta: " . $connection->error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Imágenes</title>
    <style>
        .imagen-catalogo {
            width: 200px;
            height: 200px;
            object-fit: cover;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td {
            padding: 10px;
            text-align: center;
            vertical-align: top;
            border: 1px solid #ddd;
        }
        .ruta-imagen {
            font-size: 12px;
            word-break: break-all;
        }
    </style>
</head>
<body>
    <h1>Listado pictogramas</h1>
    
    <table>
        <?php
        $counter = 0;
        while ($row = $result->fetch_assoc()) {
            if ($counter % 4 == 0) {
                echo "<tr>";
            }
            ?>
            <td>
                <img src="<?php echo $row['imagen']; ?>" alt="Imagen" class="imagen-catalogo">
                <p class="ruta-imagen"><?php echo $row['imagen']; ?></p>
            </td>
            <?php
            $counter++;
            if ($counter % 4 == 0) {
                echo "</tr>";
            }
        }
        
        
        ?>
    </table>
</body>
</html>

<?php
$connection->close();
?>
