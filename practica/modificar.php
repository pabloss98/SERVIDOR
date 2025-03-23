<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

$databaseConfig = [
    'host' => 'localhost',
    'dbName' => 'diabetesdb', 
    'username' => 'root',    
    'password' => ''
];

$connection = new mysqli($databaseConfig['host'], $databaseConfig['username'], $databaseConfig['password'], $databaseConfig['dbName']);

if ($connection->connect_error) {
    sendResponse(['error' => 'Conexión fallida: ' . $connection->connect_error]);
}

if ($_SERVER["REQUEST_METHOD"] === "PUT") {
    $requestData = json_decode(file_get_contents("php://input"), true);

    $usuario = $requestData["usuario"] ?? null;
    $nombre = $requestData["nombre"] ?? null;
    $apellido = $requestData["apellidos"] ?? null;
    $fecha_nacimiento = $requestData["fechaNacimiento"] ?? null;
    $contra = !empty($requestData["password"]) ? password_hash($requestData["password"], PASSWORD_BCRYPT) : null;


    if (!$usuario || !$nombre || !$apellido || !$fecha_nacimiento) {
        sendResponse(['error' => 'Faltan datos obligatorios: usuario, nombre, apellidos o fecha de nacimiento']);
    }

    $query = "UPDATE usuario SET nombre = ?, apellidos = ?, fecha_nacimiento = ?";
    $params = [$nombre, $apellido, $fecha_nacimiento];
    $paramTypes = 'sss';

    if ($contra) {
        $query .= ", contra = ?";
        $params[] = $contra;
        $paramTypes .= 's';
    }

    $query .= " WHERE usuario = ?";
    $params[] = $usuario;
    $paramTypes .= 's'; 

    $statement = $connection->prepare($query);
    if (!$statement) {
        sendResponse(['error' => 'Error al preparar la consulta: ' . $connection->error]);
    }

    $statement->bind_param($paramTypes, ...$params);

    if ($statement->execute()) {
        sendResponse(['success' => true, 'message' => 'Usuario actualizado correctamente']);
    } else {
        sendResponse(['error' => 'Error al actualizar el usuario: ' . $statement->error]);
    }

    $statement->close();
    $connection->close();
}

function sendResponse($response) {
    echo json_encode($response);
    exit;
}
?>
