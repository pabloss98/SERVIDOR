<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["Id"])) {
    header("Location: Login.php");
    exit();
}

$hn = "localhost"; 
$un = "root";      
$pw = "";          
$db = "diabetesdb"; 

$conn = new mysqli($hn, $un, $pw, $db);

if ($conn->connect_error) die("Fatal Error");

// Obtener el ID del usuario de la sesión
$id_usuario = $_SESSION["Id"];

// Consultar datos agrupados por día y tipo de comida SOLO para el usuario actual
$sql = "SELECT c.fecha, c.deporte, c.lenta, cm.tipo_comida, cm.gl_1h, cm.gl_2h, cm.raciones, cm.insulina,
               hipo.glucosa AS hipo_glucosa, hipo.hora AS hipo_hora, 
               hiper.glucosa AS hiper_glucosa, hiper.hora AS hiper_hora
        FROM CONTROL_GLUCOSA c
        LEFT JOIN COMIDA cm ON c.fecha = cm.fecha AND c.id_usu = cm.id_usu
        LEFT JOIN HIPOGLUCEMIA hipo ON cm.fecha = hipo.fecha AND cm.tipo_comida = hipo.tipo_comida AND cm.id_usu = hipo.id_usu
        LEFT JOIN HIPERGLUCEMIA hiper ON cm.fecha = hiper.fecha AND cm.tipo_comida = hiper.tipo_comida AND cm.id_usu = hiper.id_usu
        WHERE c.id_usu = ?
        ORDER BY c.fecha ASC";

// Usar consulta preparada para evitar inyección SQL
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

// Estructurar los datos por día y tipo de comida
$data = [];
$tipo_comidas = ['Desayuno','Comida','Cena'];
while ($row = $result->fetch_assoc()) {
    if (!empty($row['tipo_comida'])) { // Solo agregar si tiene tipo_comida
        $data[$row['fecha']][$row['tipo_comida']] = $row;
        if (!in_array($row['tipo_comida'], $tipo_comidas)) {
            $tipo_comidas[] = $row['tipo_comida'];
        }
    } else {
        // Para registros que solo tienen datos de control_glucosa
        if (!isset($data[$row['fecha']])) {
            $data[$row['fecha']] = [];
        }
        // Guardar los datos de control_glucosa para usarlos después
        $data[$row['fecha']]['_control_glucosa'] = [
            'deporte' => $row['deporte'],
            'lenta' => $row['lenta']
        ];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Historial de Datos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <h2 class="text-center mb-4">Historial de Datos</h2>
    
    <!-- Mostrar el nombre de usuario -->
    
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th rowspan="2" class="text-center align-middle">Día</th>
                    <th rowspan="2" class="text-center align-middle">Deporte (min)</th>
                    <th rowspan="2" class="text-center align-middle">Insulina Lenta</th>
                    <?php foreach ($tipo_comidas as $tipo): ?>
                        <th colspan="8" class="text-center"> <?= htmlspecialchars($tipo) ?> </th>
                    <?php endforeach; ?>
                </tr>
                <tr>
                    <?php foreach ($tipo_comidas as $tipo): ?>
                        <th>Glucosa 1h</th>
                        <th>Glucosa 2h</th>
                        <th>Raciones</th>
                        <th>Insulina</th>
                        <th>Hipo Glucosa</th>
                        <th>Hipo Hora</th>
                        <th>Hiper Glucosa</th>
                        <th>Hiper Hora</th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($data)): ?>
                    <tr>
                        <td colspan="<?= 3 + (count($tipo_comidas) * 8) ?>" class="text-center">
                            No hay datos disponibles para este usuario
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($data as $fecha => $rows): ?>
                        <tr>
                            <td><?= htmlspecialchars($fecha) ?></td>
                            <?php 
                            // Obtener datos de deporte y lenta
                            $deporte = '';
                            $lenta = '';
                            
                            // Primero intentar obtener de _control_glucosa
                            if (isset($rows['_control_glucosa'])) {
                                $deporte = $rows['_control_glucosa']['deporte'];
                                $lenta = $rows['_control_glucosa']['lenta'];
                            } 
                            // Si no, intentar obtener del primer registro disponible
                            else if (!empty($rows)) {
                                $first_key = array_key_first(array_filter($rows, function($k) {
                                    return $k !== '_control_glucosa';
                                }, ARRAY_FILTER_USE_KEY));
                                if ($first_key) {
                                    $deporte = $rows[$first_key]["deporte"] ?? '';
                                    $lenta = $rows[$first_key]["lenta"] ?? '';
                                }
                            }
                            ?>
                            <td><?= htmlspecialchars($deporte) ?></td>
                            <td><?= htmlspecialchars($lenta) ?></td>
                            
                            <?php foreach ($tipo_comidas as $tipo): ?>
                                <td><?= htmlspecialchars($rows[$tipo]["gl_1h"] ?? '') ?></td>
                                <td><?= htmlspecialchars($rows[$tipo]["gl_2h"] ?? '') ?></td>
                                <td><?= htmlspecialchars($rows[$tipo]["raciones"] ?? '') ?></td>
                                <td><?= htmlspecialchars($rows[$tipo]["insulina"] ?? '') ?></td>
                                <td><?= htmlspecialchars($rows[$tipo]["hipo_glucosa"] ?? '') ?></td>
                                <td><?= htmlspecialchars($rows[$tipo]["hipo_hora"] ?? '') ?></td>
                                <td><?= htmlspecialchars($rows[$tipo]["hiper_glucosa"] ?? '') ?></td>
                                <td><?= htmlspecialchars($rows[$tipo]["hiper_hora"] ?? '') ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="d-flex justify-content-between mt-3">
            <a href="Formulario.html" class="btn btn-primary w-100">Volver</a>
        </div>
    </div>
            <a href="modificar.php" class="btn btn-warning">Modificar datos</a>
            <a href="Eliminar.php" class="btn btn-danger">Eliminar datos</a>
            <a href="Estadisticas.php" class="btn btn-primary">Estadísticas</a>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php 
$stmt->close();
$conn->close(); 
?>
