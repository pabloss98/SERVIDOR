<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

$databaseConfig = [
    'host' => 'localhost',
    'dbName' => 'controldiabetes',
    'username' => 'root',
    'password' => ''
];

$conn = new mysqli($databaseConfig['host'], $databaseConfig['username'], $databaseConfig['password'], $databaseConfig['dbName']);

if ($conn->connect_error) {
    sendResponse(['error' => 'Conexión fallida: ' . $conn->connect_error]);
}

$month = filter_input(INPUT_GET, 'month', FILTER_VALIDATE_INT) ?: date('m');
$year = filter_input(INPUT_GET, 'year', FILTER_VALIDATE_INT) ?: date('Y');

if (!$month || !$year) {
    sendResponse(['error' => 'Mes o año no válidos']);
}

$sql = "SELECT lenta FROM controlglucosa WHERE MONTH(fecha) = ? AND YEAR(fecha) = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    sendResponse(['error' => 'Error en la preparación de la consulta: ' . $conn->error]);
}

$stmt->bind_param("ii", $month, $year);
$stmt->execute();
$result = $stmt->get_result();

$lenta_values = [];
while ($row = $result->fetch_assoc()) {
    if (isset($row['lenta'])) {
        $lenta_values[] = floatval($row['lenta']);
    }
}

$stmt->close();
$conn->close();

$response = calculateStatistics($lenta_values);

sendResponse($response);

function calculateStatistics(array $values) {
    $count = count($values);
    
    if ($count === 0) {
        return [
            'mean' => null,
            'min' => null,
            'max' => null,
            'values' => []
        ];
    }

    return [
        'mean' => array_sum($values) / $count,
        'min' => min($values),
        'max' => max($values),
        'values' => $values
    ];
}

function sendResponse(array $response) {
    echo json_encode($response);
    exit;
}

?>
