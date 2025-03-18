<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../config/database.php';

$data = json_decode(file_get_contents('php://input'));

try {
    $query = "UPDATE users SET fullName = ?, birthDate = ? WHERE username = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        $data->fullName,
        $data->birthDate,
        $data->username
    ]);
    
    echo json_encode(['message' => 'Usuario actualizado exitosamente']);
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
