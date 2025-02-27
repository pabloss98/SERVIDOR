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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $idpersona = $_POST['persona'];
    $idimagen = $_POST['imagen_seleccionada'];
    
    $query = "INSERT INTO agenda (fecha, hora, idpersona, idimagen) VALUES (?, ?, ?, ?)";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("ssii", $fecha, $hora, $idpersona, $idimagen);
    
    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Registro guardado correctamente</div>";
    } else {
        echo "<div class='alert alert-danger'>Error al guardar el registro: " . $stmt->error . "</div>";
    }
    $stmt->close();
}

$query_personas = "SELECT * FROM personas";
$result_personas = $connection->query($query_personas);

$query_imagenes = "SELECT * FROM imagenes";
$result_imagenes = $connection->query($query_imagenes);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Agenda</title>
    <style>
        .imagen-catalogo {
            width: 150px;
            height: 150px;
            object-fit: cover;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        td {
            padding: 10px;
            text-align: center;
            vertical-align: top;
            border: 1px solid #ddd;
        }
        .form-container {
            margin-bottom: 20px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        select, input[type="date"] {
            width: 200px;
            padding: 5px;
        }
        .submit-btn {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .submit-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Programar Actividad</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="fecha">Fecha:</label>
                <input type="date" id="fecha" name="fecha" required>
            </div>

            <div class="form-group">
                <label for="hora">Hora:</label>
                <input type="time" id="hora" name="hora" required>
                    
                
            </div>

            <div class="form-group">
                <label for="persona">Persona:</label>
                <select id="persona" name="persona" required>
                    <option value="">Seleccione una persona</option>
                    <?php
                    while ($persona = $result_personas->fetch_assoc()) {
                        echo "<option value='" . $persona['id'] . "'>" . $persona['nombre'] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <h3>Seleccione una imagen:</h3>
            <table>
                <?php
                $counter = 0;
                while ($row = $result_imagenes->fetch_assoc()) {
                    if ($counter % 4 == 0) {
                        echo "<tr>";
                    }
                    ?>
                    <td>
                        <img src="<?php echo $row['imagen']; ?>" alt="Imagen" class="imagen-catalogo"><br>
                        <input type="radio" name="imagen_seleccionada" value="<?php echo $row['descripcion']; ?>" required>
                    </td>
                    <?php
                    $counter++;
                    if ($counter % 4 == 0) {
                        echo "</tr>";
                    }
                }
                if ($counter % 4 != 0) {
                    echo "</tr>";
                }
                ?>
            </table>

            <div class="form-group" style="margin-top: 20px;">
                <button type="submit" class="submit-btn">Guardar en Agenda</button>
            </div>
            <a href="Listado.php">Volver al listado</a>
        </form>
    </div>
</body>
</html>

<?php
$connection->close();
?>
