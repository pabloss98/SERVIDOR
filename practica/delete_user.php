<?php
// Configuración de la base de datos
$host = 'localhost';
$db = 'diabetesdb'; // Nombre correcto de la base de datos
$user = 'root';
$pass = ''; // Contraseña por defecto en XAMPP

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Crear conexión
$conn = new mysqli($host, $user, $pass, $db);

// Verificar conexión
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Conexión fallida: ' . $conn->connect_error]));
}

// Obtener el ID del usuario a eliminar
if (isset($_GET['id'])) {
    $userId = intval($_GET['id']); // Sanitizar el ID

    // Primero, eliminar los registros relacionados en control_glucosa
    $sqlDeleteControl = "DELETE FROM control_glucosa WHERE id_usu = ?";
    $stmtControl = $conn->prepare($sqlDeleteControl);
    
    if ($stmtControl === false) {
        die(json_encode(['success' => false, 'message' => 'Error en la consulta para eliminar control_glucosa.']));
    }

    $stmtControl->bind_param("i", $userId);
    $stmtControl->execute();
    $stmtControl->close();

    // Luego, eliminar el usuario
    $sql = "DELETE FROM usuario WHERE id_usu = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        die(json_encode(['success' => false, 'message' => 'Error en la consulta para eliminar usuario.']));
    }

    $stmt->bind_param("i", $userId);

    // Ejecutar la consulta para eliminar el usuario
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Usuario eliminado con éxito.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al eliminar el usuario: ' . $stmt->error]);
    }

    // Cerrar la declaración
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'ID de usuario no proporcionado.']);
}

// Cerrar la conexión
$conn->close();
?>
