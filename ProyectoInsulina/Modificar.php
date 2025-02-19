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
            $query = "SELECT * FROM comidas WHERE fecha = ?";
            break;
        case 'glucosa':
            $query = "SELECT * FROM glucosa WHERE fecha = ?";
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

// Procesar la actualización si se envía el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['actualizar'])) {
    $tipo = $_POST['tipo'];
    $id = $_POST['id'];
    
    switch($tipo) {
        case 'comida':
            $query = "UPDATE comidas SET tipo_comida=?, gl_1h=?, gl_2h=?, raciones=?, insulina=? WHERE id=?";
            $stmt = $connection->prepare($query);
            $stmt->bind_param("siiiii",
                    $_POST['tipo_comida'],
                    $_POST['gl_1h'], 
                    $_POST['gl_2h'], 
                    $_POST['raciones'], 
                    $_POST['insulina'], 
                    $id);
            break;
        
            case 'glucosa':
                $query = "UPDATE glucosa SET fecha=?, deporte=?, lenta=? WHERE id=?";
                $stmt = $connection->prepare($query);
                $stmt->bind_param("siii", 
                    $_POST['fecha'], 
                    $_POST['deporte'], 
                    $_POST['lenta'],
                    $id
                );
                break;
    
            case 'hiper':
                $query = "UPDATE hiperglucemia SET glucosa=?, hora=?, correccion=?, tipo_comida=?, fecha=? WHERE id=?";
                $stmt = $connection->prepare($query);
                $stmt->bind_param("issssi", 
                    $_POST['glucosa'], 
                    $_POST['hora'], 
                    $_POST['correccion'],
                    $_POST['tipo_comida'],
                    $_POST['fecha'],
                    $id
                );
                break;
    
            case 'hipo':
                $query = "UPDATE hipoglucemia SET glucosa=?, hora=?, tipo_comida=?, fecha=? WHERE id=?";
                $stmt = $connection->prepare($query);
                $stmt->bind_param("isssi", 
                    $_POST['glucosa'], 
                    $_POST['hora'], 
                    $_POST['tipo_comida'],
                    $_POST['fecha'],
                    $id
                );
                break;
    }
    
    if ($stmt->execute()) {
        $mensaje = "Registro actualizado con éxito";
    } else {
        $error = "Error al actualizar el registro";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Modificar Registros</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Modificar Registros</h2>
        
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
                    echo "<form method='POST'>";
                    echo "<input type='hidden' name='tipo' value='" . $_GET['tipo'] . "'>";
                    echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
                    
                    // Mostrar campos según el tipo de registro
                    switch($_GET['tipo']) {
                        case 'comida':
                            ?>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Tipo de Comida</label>
                                    <input type="text" class="form-control" name="tipo_comida" 
                                           value="<?php echo $row['tipo_comida']; ?>">
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label">Glucosa 1h</label>
                                    <input type="number" class="form-control" name="gl_1h" 
                                           value="<?php echo $row['gl_1h']; ?>">
                                </div>
                                <!-- Añadir más campos según necesidad -->
                            </div>
                            <?php
                            break;
                        // Añadir casos para otros tipos
                    }
                    
                    echo "<button type='submit' name='actualizar' class='btn btn-success'>Actualizar</button>";
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
