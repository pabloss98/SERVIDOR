<?php
session_start();
$hn = "localhost";
$un = "root";
$pw = "";
$db = "diabetesdb";

$connection = new mysqli($hn, $un, $pw, $db);

if ($connection->connect_error) {
    die("Error de conexión: " . $connection->connect_error);
}


// Función para obtener registros por fecha y tipo
function obtenerRegistros($connection, $fecha, $tipo) {
    $query = "";
    switch($tipo) {
        case 'comida':
            $query = "SELECT * FROM comida WHERE fecha = ?";
            break;
        case 'glucosa':
            $query = "SELECT * FROM control_glucosa WHERE fecha = ?";
            break;
        case 'hiper':
            $query = "SELECT * FROM hiperglucemia WHERE fecha = ?";
            break;
        case 'hipo':
            $query = "SELECT * FROM hipoglucemia WHERE fecha = ?";
            break;
    }
    
    $stmt = $connection->prepare($query);
    $stmt->bind_param("s", $fecha);
    $stmt->execute();
    return $stmt->get_result();
}

// Procesar la eliminación si se envía el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['eliminar'])) {
    $tipo = $_POST['tipo'];
    $id = $_POST['id'];
    
    switch($tipo) {
        case 'comida':
            $query = "DELETE FROM comida WHERE id = ?";
            break;
        case 'glucosa':
            $query = "DELETE FROM control_glucosa WHERE id = ?";
            break;
        case 'hiper':
            $query = "DELETE FROM hiperglucemia WHERE id = ?";
            break;
        case 'hipo':
            $query = "DELETE FROM hipoglucemia WHERE id = ?";
            break;
    }
    
    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        $mensaje = "Registro eliminado con éxito";
    } else {
        $error = "Error al eliminar el registro";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Eliminar Registros</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Eliminar Registros</h2>
        
        <!-- Formulario de búsqueda -->
        <form method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <label class="form-label">Fecha</label>
                    <input type="date" name="fecha" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tipo de Registro</label>
                    <select name="tipo" class="form-select" required>
                        <option value="comida">Comida</option>
                        <option value="glucosa">Glucosa</option>
                        <option value="hiper">Hiperglucemia</option>
                        <option value="hipo">Hipoglucemia</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary d-block">Buscar</button>
                </div>
            </div>
        </form>

        <?php
        if (isset($_GET['fecha']) && isset($_GET['tipo'])) {
            $registros = obtenerRegistros($connection, $_GET['fecha'], $_GET['tipo']);
            
            if ($registros->num_rows > 0) {
                while ($row = $registros->fetch_assoc()) {
                    echo "<div class='card mb-3'>";
                    echo "<div class='card-body'>";
                    echo "<form method='POST' onsubmit='return confirm(\"¿Está seguro de que desea eliminar este registro?\")'>";
                    echo "<input type='hidden' name='tipo' value='" . $_GET['tipo'] . "'>";
                    echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
                    
                    // Mostrar información del registro según el tipo
                    switch($_GET['tipo']) {
                        case 'comida':
                            echo "<p>Tipo de Comida: " . $row['tipo_comida'] . "</p>";
                            echo "<p>Glucosa 1h: " . $row['gl_1h'] . "</p>";
                            echo "<p>Glucosa 2h: " . $row['gl_2h'] . "</p>";
                            echo "<p>Raciones: " . $row['raciones'] . "</p>";
                            echo "<p>Insulina: " . $row['insulina'] . "</p>";
                            break;
                        case 'glucosa':
                            echo "<p>Fecha: " . $row['fecha'] . "</p>";
                            echo "<p>Deporte: " . $row['deporte'] . "</p>";
                            echo "<p>Lenta: " . $row['lenta'] . "</p>";
                            break;
                        case 'hiper':
                            echo "<p>Glucosa: " . $row['glucosa'] . "</p>";
                            echo "<p>Hora: " . $row['hora'] . "</p>";
                            echo "<p>Corrección: " . $row['correccion'] . "</p>";
                            echo "<p>Tipo de Comida: " . $row['tipo_comida'] . "</p>";
                            break;
                        case 'hipo':
                            echo "<p>Glucosa: " . $row['glucosa'] . "</p>";
                            echo "<p>Hora: " . $row['hora'] . "</p>";
                            echo "<p>Tipo de Comida: " . $row['tipo_comida'] . "</p>";
                            break;
                    }
                    
                    echo "<button type='submit' name='eliminar' class='btn btn-danger'>Eliminar</button>";
                    echo "</form>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<div class='alert alert-info'>No se encontraron registros para la fecha seleccionada.</div>";
            }
        }
        ?>

        <?php if(isset($mensaje)): ?>
            <div class="alert alert-success"><?php echo $mensaje; ?></div>
        <?php endif; ?>
        
        <?php if(isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
