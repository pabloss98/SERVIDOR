<?php
$host = 'localhost';
$db = 'diabetesdb';
$user = 'root';
$pass = ''; 

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Conexión fallida: ' . $conn->connect_error]);
    exit();
}

if (isset($_GET['id'])) {
    $userId = intval($_GET['id']); 

    $sqlDeleteControl = "DELETE FROM control_glucosa WHERE id_usu = ?";
    $stmtControl = $conn->prepare($sqlDeleteControl);
    
    if ($stmtControl === false) {
        echo json_encode(['success' => false, 'message' => 'Error en la consulta para eliminar los registros en control_glucosa.']);
        exit();
    }

    $stmtControl->bind_param("i", $userId);
    if (!$stmtControl->execute()) {
        echo json_encode(['success' => false, 'message' => 'Error al eliminar los registros de control_glucosa.']);
        exit();
    }
    $stmtControl->close(); 

    $sqlDeleteUser = "DELETE FROM usuario WHERE id_usu = ?";
    $stmtUser = $conn->prepare($sqlDeleteUser);

    if ($stmtUser === false) {
        echo json_encode(['success' => false, 'message' => 'Error en la consulta para eliminar el usuario.']);
        exit();
    }

    $stmtUser->bind_param("i", $userId);
    if ($stmtUser->execute()) {
        echo json_encode(['success' => true, 'message' => 'Usuario eliminado con éxito.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al eliminar el usuario: ' . $stmtUser->error]);
    }

    $stmtUser->close();
} else {
    echo json_encode(['success' => false, 'message' => 'No se proporcionó un ID de usuario.']);
}

$conn->close();
?>
