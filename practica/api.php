<?php
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
header("Access-Control-Allow-Headers: Content-Type"); 

$servername = "localhost";
$username = "root"; 
$password = "";     
$dbname = "diabetesdb"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['username'], $data['password'], $data['name'], $data['surname'], $data['birthDate'])) {
        $usuario = $data['username'];
        $contra = password_hash($data['password'], PASSWORD_DEFAULT); 
        $nombre = $data['name'];
        $apellidos = $data['surname'];
        $fecha_nacimiento = $data['birthDate'];

        $stmt = $conn->prepare("INSERT INTO usuario (usuario, contra, nombre, apellidos, fecha_nacimiento) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $usuario, $contra, $nombre, $apellidos, $fecha_nacimiento);

        if ($stmt->execute()) {
            echo json_encode([
                "id" => $stmt->insert_id,
                "usuario" => $usuario,
                "nombre" => $nombre,
                "apellidos" => $apellidos,
                "fecha_nacimiento" => $fecha_nacimiento
            ]);
        } else {
            echo json_encode(["error" => "Error al insertar los datos: " . $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(["error" => "Faltan datos necesarios en la solicitud."]);
    }
}

$conn->close();
?>
