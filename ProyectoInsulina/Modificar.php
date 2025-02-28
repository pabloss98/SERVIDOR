<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["Id"])) {
    header("Location: Login.php");
    exit();
}

$hn = "fdb1028.awardspace.net";
$un = "4597186_diabetesdb";
$pw = "insulina123";
$db = "4597186_diabetesdb";

$connection = new mysqli($hn, $un, $pw, $db);

if ($connection->connect_error) {
    die("Error de conexión: " . $connection->connect_error);
}

// Función para obtener registros por fecha y tipo
function obtenerRegistros($connection, $fecha, $tipo) {
    // Obtener el ID del usuario de la sesión
    $id_usuario = $_SESSION["Id"];
    
    $query = "";
    switch($tipo) {
        case 'comida':
            $query = "SELECT id_usu, fecha, tipo_comida, gl_1h, gl_2h, raciones, insulina FROM comida WHERE fecha = ? AND id_usu = ?";
            break;
        case 'glucosa':
            $query = "SELECT id_usu, fecha, deporte, lenta FROM control_glucosa WHERE fecha = ? AND id_usu = ?";
            break;
        case 'hiper':
            $query = "SELECT id_usu, fecha, tipo_comida, glucosa, hora, correccion FROM hiperglucemia WHERE fecha = ? AND id_usu = ?";
            break;
        case 'hipo':
            $query = "SELECT id_usu, fecha, tipo_comida, glucosa, hora FROM hipoglucemia WHERE fecha = ? AND id_usu = ?";
            break;
    }
    
    $stmt = $connection->prepare($query);
    $stmt->bind_param("si", $fecha, $id_usuario);
    $stmt->execute();
    return $stmt->get_result();
}

// Procesar la actualización si se envía el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['actualizar'])) {
    $tipo = $_POST['tipo'];
    $id = $_SESSION['Id']; // Usar Id de la sesión, no id_usu
    
    switch($tipo) {
        case 'comida':
            $query = "UPDATE comida SET fecha=?, tipo_comida=?, gl_1h=?, gl_2h=?, raciones=?, insulina=? WHERE id_usu=? AND fecha=? AND tipo_comida=?";
            $stmt = $connection->prepare($query);
            $stmt->bind_param("ssiiiiiss",
                $_POST['fecha'],
                $_POST['tipo_comida'],
                $_POST['gl_1h'], 
                $_POST['gl_2h'], 
                $_POST['raciones'], 
                $_POST['insulina'],
                $id,
                $_POST['fecha_original'],
                $_POST['tipo_comida_original']
            );
            break;
            
        case 'glucosa':
            $query = "UPDATE control_glucosa SET fecha=?, deporte=?, lenta=? WHERE id_usu=? AND fecha=?";
            $stmt = $connection->prepare($query);
            $stmt->bind_param("siiis", 
                $_POST['fecha'], 
                $_POST['deporte'], 
                $_POST['lenta'],
                $id,
                $_POST['fecha_original']
            );
            break;

        case 'hiper':
            $query = "UPDATE hiperglucemia SET glucosa=?, hora=?, correccion=?, tipo_comida=?, fecha=? WHERE id_usu=? AND fecha=? AND tipo_comida=?";
            $stmt = $connection->prepare($query);
            $stmt->bind_param("issssiss", 
                $_POST['glucosa'], 
                $_POST['hora'], 
                $_POST['correccion'],
                $_POST['tipo_comida'],
                $_POST['fecha'],
                $id,
                $_POST['fecha_original'],
                $_POST['tipo_comida_original']
            );
            break;

        case 'hipo':
            $query = "UPDATE hipoglucemia SET glucosa=?, hora=?, tipo_comida=?, fecha=? WHERE id_usu=? AND fecha=? AND tipo_comida=?";
            $stmt = $connection->prepare($query);
            $stmt->bind_param("isssiss", 
                $_POST['glucosa'], 
                $_POST['hora'], 
                $_POST['tipo_comida'],
                $_POST['fecha'],
                $id,
                $_POST['fecha_original'],
                $_POST['tipo_comida_original']
            );
            break;
    }
    
    if ($stmt->execute()) {
        $mensaje = "Registro actualizado con éxito";
    } else {
        $error = "Error al actualizar el registro: " . $stmt->error;
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
        <form method="POST" class="mb-4">
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
                    <button type="submit" class="btn btn-primary d-block w-100">Buscar</button>
                </div>
            </div>
        </form>

        <?php
        if (isset($_POST['fecha']) && isset($_POST['tipo']) && !isset($_POST['actualizar'])) {
            $registros = obtenerRegistros($connection, $_POST['fecha'], $_POST['tipo']);
            
            if ($registros->num_rows > 0) {
                while ($row = $registros->fetch_assoc()) {
                    echo "<div class='card mb-3'>";
                    echo "<div class='card-body'>";
                    echo "<form method='POST'>";
                    echo "<input type='hidden' name='tipo' value='" . $_POST['tipo'] . "'>";
                    echo "<input type='hidden' name='id_usu' value='" . $row['id_usu'] . "'>";
                    echo "<input type='hidden' name='fecha_original' value='" . $row['fecha'] . "'>";
                    echo "<input type='hidden' name='tipo_comida_original' value='" . htmlspecialchars($row['tipo_comida'] ?? '') . "'>";
                    
                    // Mostrar campos según el tipo de registro
                    switch($_POST['tipo']) {
                        
                        case 'comida':
                            ?>
                            <div class="row">
                                <div class="col-md-2 mb-3">
                                    <label class="form-label">Fecha</label>
                                    <input type="date" class="form-control" name="fecha" 
                                           value="<?php echo htmlspecialchars($row['fecha']); ?>">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Tipo de Comida</label>
                                    <select class="form-select" name="tipo_comida">
                                        <option value="Desayuno" <?php echo $row['tipo_comida'] == 'Desayuno' ? 'selected' : ''; ?>>Desayuno</option>
                                        <option value="Comida" <?php echo $row['tipo_comida'] == 'Comida' ? 'selected' : ''; ?>>Comida</option>
                                        <option value="Cena" <?php echo $row['tipo_comida'] == 'Cena' ? 'selected' : ''; ?>>Cena</option>
                                    </select>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label">Glucosa 1h</label>
                                    <input type="number" class="form-control" name="gl_1h" 
                                           value="<?php echo htmlspecialchars($row['gl_1h']); ?>">
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label">Glucosa 2h</label>
                                    <input type="number" class="form-control" name="gl_2h" 
                                           value="<?php echo htmlspecialchars($row['gl_2h']); ?>">
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label">Raciones</label>
                                    <input type="number" class="form-control" name="raciones" 
                                           value="<?php echo htmlspecialchars($row['raciones']); ?>">
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label">Insulina</label>
                                    <input type="number" class="form-control" name="insulina" 
                                           value="<?php echo htmlspecialchars($row['insulina']); ?>">
                                </div>
                            </div>
                            <?php
                            break;



                        case 'glucosa':
                            ?>
                            <div class="row">
                                <div class="col-md-2 mb-3">
                                    <label class="form-label">Fecha</label>
                                    <input type="date" class="form-control" name="fecha" 
                                           value="<?php echo $row['fecha']; ?>">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Deporte</label>
                                    <input type="text" class="form-control" name="deporte" 
                                           value="<?php echo $row['deporte']; ?>">
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label">Lenta</label>
                                    <input type="number" class="form-control" name="lenta" 
                                           value="<?php echo $row['lenta']; ?>">
                                </div>
                                <!-- Añadir más campos según necesidad -->
                            </div>
                            <?php
                            break;

                            case 'hiper':
                                ?>
                                <div class="row">
                                    <div class="col-md-2 mb-3">
                                        <label class="form-label">Fecha</label>
                                        <input type="date" class="form-control" name="fecha" 
                                               value="<?php echo htmlspecialchars($row['fecha']); ?>">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Tipo de Comida</label>
                                        <select class="form-select" name="tipo_comida">
                                            <option value="Desayuno" <?php echo $row['tipo_comida'] == 'Desayuno' ? 'selected' : ''; ?>>Desayuno</option>
                                            <option value="Comida" <?php echo $row['tipo_comida'] == 'Comida' ? 'selected' : ''; ?>>Comida</option>
                                            <option value="Cena" <?php echo $row['tipo_comida'] == 'Cena' ? 'selected' : ''; ?>>Cena</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label class="form-label">Glucosa</label>
                                        <input type="number" class="form-control" name="glucosa" 
                                               value="<?php echo htmlspecialchars($row['glucosa']); ?>">
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label class="form-label">Hora</label>
                                        <input type="time" class="form-control" name="hora" 
                                               value="<?php echo htmlspecialchars($row['hora']); ?>">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Corrección</label>
                                        <input type="text" class="form-control" name="correccion" 
                                               value="<?php echo htmlspecialchars($row['correccion']); ?>">
                                    </div>
                                </div>
                                <?php
                                break;

                                case 'hipo':
                                    ?>
                                    <div class="row">
                                        <div class="col-md-2 mb-3">
                                            <label class="form-label">Fecha</label>
                                            <input type="date" class="form-control" name="fecha" 
                                                   value="<?php echo htmlspecialchars($row['fecha']); ?>">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Tipo de Comida</label>
                                            <select class="form-select" name="tipo_comida">
                                                <option value="Desayuno" <?php echo $row['tipo_comida'] == 'Desayuno' ? 'selected' : ''; ?>>Desayuno</option>
                                                <option value="Comida" <?php echo $row['tipo_comida'] == 'Comida' ? 'selected' : ''; ?>>Comida</option>
                                                <option value="Cena" <?php echo $row['tipo_comida'] == 'Cena' ? 'selected' : ''; ?>>Cena</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label class="form-label">Glucosa</label>
                                            <input type="number" class="form-control" name="glucosa" 
                                                   value="<?php echo htmlspecialchars($row['glucosa']); ?>">
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label class="form-label">Hora</label>
                                            <input type="time" class="form-control" name="hora" 
                                                   value="<?php echo htmlspecialchars($row['hora']); ?>">
                                        </div>
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

        <div class="text-center mt-4">
            <a href="Formulario.html" class="btn btn-primary">Volver al Formulario</a>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
