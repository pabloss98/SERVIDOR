<?php

$servername = "localhost";
$username = "root"; 
$password = "";     
$dbname = "diabetesdb";  

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

// Manejo de pre-flight requests (CORS)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Conexión fallida: ' . $conn->connect_error]));
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = json_decode(file_get_contents("php://input"), true);
    $usuario = isset($data['usuario']) ? trim($data['usuario']) : null;

    if ($usuario) {
        $sqlGetId = "SELECT id_usu FROM usuario WHERE usuario = ?";
        $stmtGetId = $conn->prepare($sqlGetId);
        $stmtGetId->bind_param("s", $usuario);
        $stmtGetId->execute();
        $result = $stmtGetId->get_result();
        $stmtGetId->close();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $idUsuario = $row['id_usu'];

            $sqlDeleteControl = "DELETE FROM control_glucosa WHERE id_usu = ?";
            $stmtControl = $conn->prepare($sqlDeleteControl);
            $stmtControl->bind_param("i", $idUsuario);
            $stmtControl->execute();
            $stmtControl->close();

            $sql = "DELETE FROM usuario WHERE id_usu = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $idUsuario);

            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => "Usuario '$usuario' eliminado con éxito."]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al eliminar el usuario: ' . $stmt->error]);
            }

            $stmt->close();
        } else {
            echo json_encode(['success' => false, 'message' => 'Usuario no encontrado.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Nombre de usuario no proporcionado.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método de solicitud no permitido.']);
}

$conn->close();
?>
