<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../config/database.php';

$data = json_decode(file_get_contents('php://input'));

try {
    $query = "INSERT INTO users (username, password, fullName, birthDate) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        $data->username,
        password_hash($data->password, PASSWORD_DEFAULT),
        $data->fullName,
        $data->birthDate
    ]);
    
    echo json_encode(['message' => 'Usuario creado exitosamente']);
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
