<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Conectar a la base de datos
$host = 'localhost';
$db = 'diabetesdb'; // Nombre correcto de la base de datos
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

// Verificar conexión
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Conexión fallida: ' . $conn->connect_error]));
}

// Consulta para obtener todos los usuarios
$sql = "SELECT id_usu, usuario, nombre, apellidos, fecha_nacimiento FROM usuario"; // Selecciona todas las columnas necesarias
$result = $conn->query($sql);

$users = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

$conn->close();
echo json_encode($users); // Devuelve todos los datos de los usuarios
?>
