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

$query_personas = "SELECT * FROM personas";
$result_personas = $connection->query($query_personas);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Agenda</title>
    <style>
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
        }
        .form-container {
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
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
        .agenda-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .agenda-table td {
            border: 1px solid #ddd;
            padding: 15px;
            text-align: center;
            width: 50%;
        }
        .imagen-agenda {
            width: 200px;
            height: 200px;
            object-fit: cover;
        }
        .hora {
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 1.2em;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2>Ver Agenda</h2>
            <form method="GET" action="">
                <div class="form-group">
                    <label for="fecha">Fecha:</label>
                    <input type="date" id="fecha" name="fecha" required 
                           value="<?php echo isset($_GET['fecha']) ? $_GET['fecha'] : date('Y-m-d'); ?>">
                </div>

                <div class="form-group">
                    <label for="persona">Persona:</label>
                    <select id="persona" name="persona" required>
                        <option value="">Seleccione una persona</option>
                        <?php
                        while ($persona = $result_personas->fetch_assoc()) {
                            $selected = (isset($_GET['persona']) && $_GET['persona'] == $persona['id']) ? 'selected' : '';
                            echo "<option value='" . $persona['id'] . "' $selected>" . $persona['nombre'] . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <button type="submit" class="submit-btn">Consultar Agenda</button>
            </form>
        </div>

        <?php
        if (isset($_GET['fecha']) && isset($_GET['persona'])) {
            $fecha = $connection->real_escape_string($_GET['fecha']);
            $idpersona = $connection->real_escape_string($_GET['persona']);
        
            $query = "SELECT a.fecha, a.hora, i.imagen, i.descripcion, p.nombre 
                     FROM agenda a 
                     JOIN imagenes i ON a.idimagen = i.descripcion 
                     JOIN personas p ON a.idpersona = p.idpersona
                     WHERE a.fecha = ? AND a.idpersona = ? 
                     ORDER BY a.hora";
            
            $stmt = $connection->prepare($query);
            $stmt->bind_param("si", $fecha, $idpersona);
            $stmt->execute();
            $result = $stmt->get_result();
        
            if ($result->num_rows > 0) {
                $first_row = $result->fetch_assoc();
                $persona_nombre = $first_row['nombre'];
                $result->data_seek(0); 
                ?>
                <h3>Agenda de <?php echo $persona_nombre; ?> - <?php echo date('d/m/Y', strtotime($fecha)); ?></h3>
                <table class="agenda-table">
                    <?php
                    $counter = 0;
                    while ($row = $result->fetch_assoc()) {
                        if ($counter % 2 == 0) {
                            echo "<tr>";
                        }
                        ?>
                        <td>
                            <div class="hora"><?php echo $row['hora']; ?></div>
                            <img src="<?php echo $row['imagen']; ?>" class="imagen-agenda" alt="<?php echo $row['descripcion']; ?>">
                        </td>
                        <?php
                        if ($counter % 2 == 1) {
                            echo "</tr>";
                        }
                        $counter++;
                    }
                    
                    ?>
                </table>
                <?php
            } else {
                echo "<p>No hay actividades programadas para esta fecha.</p>";
            }
            $stmt->close();
        }
        ?>
