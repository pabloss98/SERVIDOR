<?php
session_start();

$hn = "localhost"; 
$un = "root";      
$pw = "";          
$db = "diabetesdb"; 

$conn = new mysqli($hn, $un, $pw, $db);

if ($conn->connect_error) die("Fatal Error");

// Obtener el ID del usuario de la sesión
$id_usuario = $_SESSION['Id'];

// Establecer período de tiempo (por defecto: último mes)
$periodo = isset($_GET['periodo']) ? $_GET['periodo'] : '1month';

switch ($periodo) {
    case '1week':
        $fecha_inicio = date('Y-m-d', strtotime('-1 week'));
        $titulo_periodo = "última semana";
        break;
    case '2weeks':
        $fecha_inicio = date('Y-m-d', strtotime('-2 weeks'));
        $titulo_periodo = "últimas 2 semanas";
        break;
    case '1month':
        $fecha_inicio = date('Y-m-d', strtotime('-1 month'));
        $titulo_periodo = "último mes";
        break;
    case '3months':
        $fecha_inicio = date('Y-m-d', strtotime('-3 months'));
        $titulo_periodo = "últimos 3 meses";
        break;
    case '6months':
        $fecha_inicio = date('Y-m-d', strtotime('-6 months'));
        $titulo_periodo = "últimos 6 meses";
        break;
    case '1year':
        $fecha_inicio = date('Y-m-d', strtotime('-1 year'));
        $titulo_periodo = "último año";
        break;
    default:
        $fecha_inicio = date('Y-m-d', strtotime('-1 month'));
        $titulo_periodo = "último mes";
}

$fecha_fin = date('Y-m-d');

// Consultar datos para estadísticas
$sql = "SELECT 
            c.fecha, 
            c.deporte, 
            c.lenta, 
            cm.tipo_comida, 
            cm.gl_1h, 
            cm.gl_2h, 
            cm.raciones, 
            cm.insulina,
            hipo.glucosa AS hipo_glucosa, 
            hipo.hora AS hipo_hora, 
            hiper.glucosa AS hiper_glucosa, 
            hiper.hora AS hiper_hora
        FROM CONTROL_GLUCOSA c
        LEFT JOIN COMIDA cm ON c.fecha = cm.fecha AND c.id_usu = cm.id_usu
        LEFT JOIN HIPOGLUCEMIA hipo ON cm.fecha = hipo.fecha AND cm.tipo_comida = hipo.tipo_comida AND cm.id_usu = hipo.id_usu
        LEFT JOIN HIPERGLUCEMIA hiper ON cm.fecha = hiper.fecha AND cm.tipo_comida = hiper.tipo_comida AND cm.id_usu = hiper.id_usu
        WHERE c.id_usu = ? AND c.fecha BETWEEN ? AND ?
        ORDER BY c.fecha ASC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iss", $id_usuario, $fecha_inicio, $fecha_fin);
$stmt->execute();
$result = $stmt->get_result();

// Inicializar arrays para estadísticas
$datos_por_dia = [];
$glucosa_1h = [];
$glucosa_2h = [];
$hipoglucemias = [];
$hiperglucemias = [];
$insulina_total = [];
$raciones_total = [];
$deporte_minutos = [];
$insulina_lenta = [];

// Procesar resultados
while ($row = $result->fetch_assoc()) {
    $fecha = $row['fecha'];
    
    // Inicializar arrays para cada fecha si no existen
    if (!isset($datos_por_dia[$fecha])) {
        $datos_por_dia[$fecha] = [
            'deporte' => $row['deporte'],
            'lenta' => $row['lenta'],
            'comidas' => []
        ];
    }
    
    // Agregar datos de comida
    if (!empty($row['tipo_comida'])) {
        $datos_por_dia[$fecha]['comidas'][$row['tipo_comida']] = [
            'gl_1h' => $row['gl_1h'],
            'gl_2h' => $row['gl_2h'],
            'raciones' => $row['raciones'],
            'insulina' => $row['insulina'],
            'hipo_glucosa' => $row['hipo_glucosa'],
            'hipo_hora' => $row['hipo_hora'],
            'hiper_glucosa' => $row['hiper_glucosa'],
            'hiper_hora' => $row['hiper_hora']
        ];
        
        // Recopilar datos para estadísticas
        if (!empty($row['gl_1h'])) $glucosa_1h[] = $row['gl_1h'];
        if (!empty($row['gl_2h'])) $glucosa_2h[] = $row['gl_2h'];
        if (!empty($row['hipo_glucosa'])) $hipoglucemias[] = ['fecha' => $fecha, 'valor' => $row['hipo_glucosa'], 'hora' => $row['hipo_hora'], 'comida' => $row['tipo_comida']];
        if (!empty($row['hiper_glucosa'])) $hiperglucemias[] = ['fecha' => $fecha, 'valor' => $row['hiper_glucosa'], 'hora' => $row['hiper_hora'], 'comida' => $row['tipo_comida']];
        if (!empty($row['insulina'])) {
            if (!isset($insulina_total[$fecha])) $insulina_total[$fecha] = 0;
            $insulina_total[$fecha] += $row['insulina'];
        }
        if (!empty($row['raciones'])) {
            if (!isset($raciones_total[$fecha])) $raciones_total[$fecha] = 0;
            $raciones_total[$fecha] += $row['raciones'];
        }
    }
    
    // Datos de deporte e insulina lenta
    if (!empty($row['deporte'])) $deporte_minutos[$fecha] = $row['deporte'];
    if (!empty($row['lenta'])) $insulina_lenta[$fecha] = $row['lenta'];
}

// Calcular estadísticas
$stats = [
    'promedio_gl_1h' => !empty($glucosa_1h) ? array_sum($glucosa_1h) / count($glucosa_1h) : 0,
    'promedio_gl_2h' => !empty($glucosa_2h) ? array_sum($glucosa_2h) / count($glucosa_2h) : 0,
    'total_hipoglucemias' => count($hipoglucemias),
    'total_hiperglucemias' => count($hiperglucemias),
    'promedio_insulina_diaria' => !empty($insulina_total) ? array_sum($insulina_total) / count($insulina_total) : 0,
    'promedio_raciones_diarias' => !empty($raciones_total) ? array_sum($raciones_total) / count($raciones_total) : 0,
    'promedio_deporte' => !empty($deporte_minutos) ? array_sum($deporte_minutos) / count($deporte_minutos) : 0,
    'promedio_insulina_lenta' => !empty($insulina_lenta) ? array_sum($insulina_lenta) / count($insulina_lenta) : 0
];

// Preparar datos para gráficos
$fechas_grafico = array_keys($datos_por_dia);
$datos_gl_1h = [];
$datos_gl_2h = [];
$datos_insulina = [];
$datos_raciones = [];

foreach ($fechas_grafico as $fecha) {
    $gl_1h_dia = [];
    $gl_2h_dia = [];
    $insulina_dia = 0;
    $raciones_dia = 0;
    
    foreach ($datos_por_dia[$fecha]['comidas'] as $comida) {
        if (!empty($comida['gl_1h'])) $gl_1h_dia[] = $comida['gl_1h'];
        if (!empty($comida['gl_2h'])) $gl_2h_dia[] = $comida['gl_2h'];
        if (!empty($comida['insulina'])) $insulina_dia += $comida['insulina'];
        if (!empty($comida['raciones'])) $raciones_dia += $comida['raciones'];
    }
    
    $datos_gl_1h[$fecha] = !empty($gl_1h_dia) ? array_sum($gl_1h_dia) / count($gl_1h_dia) : null;
    $datos_gl_2h[$fecha] = !empty($gl_2h_dia) ? array_sum($gl_2h_dia) / count($gl_2h_dia) : null;
    $datos_insulina[$fecha] = $insulina_dia;
    $datos_raciones[$fecha] = $raciones_dia;
}

// Determinar rangos ideales
$rango_ideal_min = 70;
$rango_ideal_max = 180;

// Calcular porcentaje de lecturas en rango
$total_lecturas = count($glucosa_1h) + count($glucosa_2h);
$lecturas_en_rango = 0;

foreach ($glucosa_1h as $gl) {
    if ($gl >= $rango_ideal_min && $gl <= $rango_ideal_max) $lecturas_en_rango++;
}

foreach ($glucosa_2h as $gl) {
    if ($gl >= $rango_ideal_min && $gl <= $rango_ideal_max) $lecturas_en_rango++;
}

$porcentaje_en_rango = $total_lecturas > 0 ? ($lecturas_en_rango / $total_lecturas) * 100 : 0;

// Calcular HbA1c estimada (fórmula aproximada basada en promedios de glucosa)
$promedio_glucosa = ($stats['promedio_gl_1h'] + $stats['promedio_gl_2h']) / 2;
$hba1c_estimada = ($promedio_glucosa + 46.7) / 28.7;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Estadísticas de Diabetes</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-light">
    <div class="container mt-4 mb-5">
        <h1 class="text-center mb-4">Estadísticas de Diabetes</h1>
        
        <!-- Selector de período -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Seleccionar período</h5>
            </div>
            <div class="card-body">
                <form method="get" class="row g-3">
                    <div class="col-md-8">
                        <select name="periodo" class="form-select">
                            <option value="1week" <?= $periodo == '1week' ? 'selected' : '' ?>>Última semana</option>
                            <option value="2weeks" <?= $periodo == '2weeks' ? 'selected' : '' ?>>Últimas 2 semanas</option>
                            <option value="1month" <?= $periodo == '1month' ? 'selected' : '' ?>>Último mes</option>
                            <option value="3months" <?= $periodo == '3months' ? 'selected' : '' ?>>Últimos 3 meses</option>
                            <option value="6months" <?= $periodo == '6months' ? 'selected' : '' ?>>Últimos 6 meses</option>
                            <option value="1year" <?= $periodo == '1year' ? 'selected' : '' ?>>Último año</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary w-100">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Resumen de estadísticas -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Resumen de la <?= $titulo_periodo ?></h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <div class="card h-100 border-primary">
                            <div class="card-body text-center">
                                <h5 class="card-title">Promedio de Glucosa</h5>
                                <p class="display-4"><?= round($promedio_glucosa) ?> mg/dl</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card h-100 border-info">
                            <div class="card-body text-center">
                                <h5 class="card-title">HbA1c Estimada</h5>
                                <p class="display-4"><?= number_format($hba1c_estimada, 1) ?>%</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card h-100 border-success">
                            <div class="card-body text-center">
                                <h5 class="card-title">Tiempo en Rango</h5>
                                <p class="display-4"><?= round($porcentaje_en_rango) ?>%</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card h-100 border-warning">
                            <div class="card-body text-center">
                                <h5 class="card-title">Insulina Diaria</h5>
                                <p class="display-4"><?= round($stats['promedio_insulina_diaria'], 1) ?> U</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row mt-3">
                    <div class="col-md-3 mb-3">
                        <div class="card h-100 border-danger">
                            <div class="card-body text-center">
                                <h5 class="card-title">Hipoglucemias</h5>
                                <p class="display-4"><?= $stats['total_hipoglucemias'] ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card h-100 border-danger">
                            <div class="card-body text-center">
                                <h5 class="card-title">Hiperglucemias</h5>
                                <p class="display-4"><?= $stats['total_hiperglucemias'] ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card h-100 border-success">
                            <div class="card-body text-center">
                                <h5 class="card-title">Deporte Diario</h5>
                                <p class="display-4"><?= round($stats['promedio_deporte']) ?> min</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card h-100 border-warning">
                            <div class="card-body text-center">
                                <h5 class="card-title">Raciones Diarias</h5>
                                <p class="display-4"><?= round($stats['promedio_raciones_diarias'], 1) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Gráficos -->
        <div class="row">
            <!-- Gráfico de Glucosa -->
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Tendencia de Glucosa</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="glucosaChart"></canvas>
                    </div>
                </div>
            </div>
            
            <!-- Gráfico de Insulina y Raciones -->
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Insulina y Raciones</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="insulinaRacionesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Eventos de Hipoglucemia -->
        <div class="card mb-4">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0">Eventos de Hipoglucemia</h5>
            </div>
            <div class="card-body">
                <?php if (count($hipoglucemias) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Comida</th>
                                    <th>Hora</th>
                                    <th>Valor (mg/dl)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($hipoglucemias as $hipo): ?>
                                    <tr>
                                        <td><?= $hipo['fecha'] ?></td>
                                        <td><?= $hipo['comida'] ?></td>
                                        <td><?= $hipo['hora'] ?></td>
                                        <td><?= $hipo['valor'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-center">No se registraron hipoglucemias en este período.</p>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Eventos de Hiperglucemia -->
        <div class="card mb-4">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0">Eventos de Hiperglucemia</h5>
            </div>
            <div class="card-body">
                <?php if (count($hiperglucemias) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Comida</th>
                                    <th>Hora</th>
                                    <th>Valor (mg/dl)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($hiperglucemias as $hiper): ?>
                                    <tr>
                                        <td><?= $hiper['fecha'] ?></td>
                                        <td><?= $hiper['comida'] ?></td>
                                        <td><?= $hiper['hora'] ?></td>
                                        <td><?= $hiper['valor'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-center">No se registraron hiperglucemias en este período.</p>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Botones de navegación -->
        <div class="d-flex justify-content-between">
            <a href="Formulario.html" class="btn btn-primary">Volver al formulario</a>
            <a href="historial.php" class="btn btn-secondary">Ver historial completo</a>
        </div>
    </div>
    
    <script>
    var ctxGlucosa = document.getElementById('glucosaChart').getContext('2d');
    var glucosaChart = new Chart(ctxGlucosa, {
        type: 'line',
        data: {
            labels: <?= json_encode($fechas_grafico) ?>,
            datasets: [{
                label: 'Glucosa 1h',
                data: <?= json_encode(array_values($datos_gl_1h)) ?>,
                borderColor: 'blue',
                fill: false,
                tension: 0.1
            }, {
                label: 'Glucosa 2h',
                data: <?= json_encode(array_values($datos_gl_2h)) ?>,
                borderColor: 'red',
                fill: false,
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: false,
                    title: {
                        display: true,
                        text: 'Nivel de Glucosa (mg/dL)'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Fecha'
                    }
                }
            }
        }
    });

    var ctxInsulina = document.getElementById('insulinaRacionesChart').getContext('2d');
    var insulinaChart = new Chart(ctxInsulina, {
        type: 'bar',
        data: {
            labels: <?= json_encode($fechas_grafico) ?>,
            datasets: [{
                label: 'Insulina Total',
                data: <?= json_encode(array_values($datos_insulina)) ?>,
                backgroundColor: 'rgba(0, 123, 255, 0.5)'
            }, {
                label: 'Raciones Totales',
                data: <?= json_encode(array_values($datos_raciones)) ?>,
                backgroundColor: 'rgba(255, 193, 7, 0.5)'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Cantidad'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Fecha'
                    }
                }
            }
        }
    });
</script>
</body>
</html>

                
