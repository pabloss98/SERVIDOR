<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Conectar a la base de datos
$host = 'localhost';
$db = 'controldiabetes';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die(json_encode(["error" => "Conexión fallida: " . $conn->connect_error]));
}

// Obtener el mes y el año desde la consulta
$month = isset($_GET['month']) ? filter_var($_GET['month'], FILTER_VALIDATE_INT) : date('m');
$year = isset($_GET['year']) ? filter_var($_GET['year'], FILTER_VALIDATE_INT) : date('Y');

if (!$month || !$year) {
    echo json_encode(["error" => "Mes o año no válidos"]);
    exit;
}

// Consultar los datos del valor LENTA
$sql = "SELECT lenta FROM controlglucosa WHERE MONTH(fecha) = ? AND YEAR(fecha) = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode(["error" => "Error en la preparación de la consulta: " . $conn->error]);
    exit;
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

// Calcular estadísticas
$response = [
    'mean' => count($lenta_values) > 0 ? array_sum($lenta_values) / count($lenta_values) : null,
    'min' => count($lenta_values) > 0 ? min($lenta_values) : null,
    'max' => count($lenta_values) > 0 ? max($lenta_values) : null,
    'values' => $lenta_values
];

echo json_encode($response);
?>
