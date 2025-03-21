<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

$host = 'localhost';
$db = 'diabetesdb'; // Base de datos correcta
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

// Verificar conexión
if ($conn->connect_error) {
    die(json_encode(["error" => "Conexión fallida: " . $conn->connect_error]));
}

if ($_SERVER["REQUEST_METHOD"] == "PUT") {
    // Obtener los datos enviados
    $data = json_decode(file_get_contents("php://input"), true);
    
    $usuario = $data["usuario"] ?? null;
    $nombre = $data["nombre"] ?? null;
    $apellido = $data["apellido"] ?? null;
    $FechaNac = $data["FechaNac"] ?? null;
    $clave = isset($data["clave"]) && !empty($data["clave"]) ? password_hash($data["clave"], PASSWORD_BCRYPT) : null;

    if (!$usuario || !$nombre || !$apellido || !$FechaNac) {
        echo json_encode(["error" => "Faltan datos obligatorios"]);
        exit;
    }

    // Construcción de consulta dinámica
    $sql = "UPDATE usuario SET nombre = ?, apellido = ?, FechaNac = ?";
    $params = [$nombre, $apellido, $FechaNac];
    $types = "sss";

    if ($clave) {
        $sql .= ", clave = ?";
        $params[] = $clave;
        $types .= "s";
    }

    $sql .= " WHERE usuario = ?";
    $params[] = $usuario;
    $types .= "s";

    // Preparar la consulta
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode(["error" => "Error en la preparación de la consulta: " . $conn->error]);
        exit;
    }

    $stmt->bind_param($types, ...$params);

    // Ejecutar y verificar
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Usuario actualizado correctamente"]);
    } else {
        echo json_encode(["error" => "Error al actualizar el usuario: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}

?>
