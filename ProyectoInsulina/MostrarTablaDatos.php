<?php

session_start();

$hn = "localhost"; 
$un = "root";      
$pw = "";          
$db = "diabetesdb"; 

$conn = new mysqli($hn, $un, $pw, $db);

if ($conn->connect_error) die("Fatal Error");

// Consultar datos agrupados por día y tipo de comida
$sql = "SELECT c.fecha, c.deporte, c.lenta, cm.tipo_comida, cm.gl_1h, cm.gl_2h, cm.raciones, cm.insulina,
               hipo.glucosa AS hipo_glucosa, hipo.hora AS hipo_hora, 
               hiper.glucosa AS hiper_glucosa, hiper.hora AS hiper_hora
        FROM CONTROL_GLUCOSA c
        LEFT JOIN COMIDA cm ON c.fecha = cm.fecha AND c.id_usu = cm.id_usu
        LEFT JOIN HIPOGLUCEMIA hipo ON cm.fecha = hipo.fecha AND cm.tipo_comida = hipo.tipo_comida AND cm.id_usu = hipo.id_usu
        LEFT JOIN HIPERGLUCEMIA hiper ON cm.fecha = hiper.fecha AND cm.tipo_comida = hiper.tipo_comida AND cm.id_usu = hiper.id_usu
        ORDER BY c.fecha ASC";
$result = $conn->query($sql);

// Estructurar los datos por día y tipo de comida
$data = [];
$tipo_comidas = ['Desayuno','Mediodia','Comida','Merienda','Cena'];
while ($row = $result->fetch_assoc()) {
    $data[$row['fecha']][$row['tipo_comida']] = $row;
    if (!in_array($row['tipo_comida'], $tipo_comidas)) {
        $tipo_comidas[] = $row['tipo_comida'];
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
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th rowspan="2" class="text-center align-middle">Día</th>
                    <th rowspan="2" class="text-center align-middle">Deporte</th>
                    <th rowspan="2" class="text-center align-middle">Insulina Lenta</th>
                    <?php foreach ($tipo_comidas as $tipo): ?>
                        <th colspan="8" class="text-center"> <?= $tipo ?> </th>
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
                <?php foreach ($data as $fecha => $rows): ?>
                    <tr>
                        <td><?= $fecha ?></td>
                        <td><?= $rows[array_key_first($rows)]["deporte"] ?? '' ?></td>
                        <td><?= $rows[array_key_first($rows)]["lenta"] ?? '' ?></td>
                        <?php foreach ($tipo_comidas as $tipo): ?>
                            <td><?= $rows[$tipo]["gl_1h"] ?? '' ?></td>
                            <td><?= $rows[$tipo]["gl_2h"] ?? '' ?></td>
                            <td><?= $rows[$tipo]["raciones"] ?? '' ?></td>
                            <td><?= $rows[$tipo]["insulina"] ?? '' ?></td>
                            <td><?= $rows[$tipo]["hipo_glucosa"] ?? '' ?></td>
                            <td><?= $rows[$tipo]["hipo_hora"] ?? '' ?></td>
                            <td><?= $rows[$tipo]["hiper_glucosa"] ?? '' ?></td>
                            <td><?= $rows[$tipo]["hiper_hora"] ?? '' ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="Inicio/menuControl.php" class="btn btn-primary mt-2 w-100">Volver</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php $conn->close(); ?>
