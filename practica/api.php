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
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    
    $usuario = $data['usuario'];  
    $contra = password_hash($data['contra'], PASSWORD_DEFAULT);  
    $nombre = $data['nombre'];  
    $apellidos = $data['apellidos'];  
    $fecha_nacimiento = $data['fecha_nacimiento']; 

    $sql = $conn->prepare("INSERT INTO usuario (usuario, contra, nombre, apellidos, fecha_nacimiento) VALUES (?, ?, ?, ?, ?)");
    $sql->bind_param("sssss", $usuario, $contra, $nombre, $apellidos, $fecha_nacimiento);

    if ($sql->execute()) {
        echo json_encode([
            "id" => $conn->insert_id,
            "usuario" => $usuario,
            "nombre" => $nombre,
            "apellidos" => $apellidos,
            "fecha_nacimiento" => $fecha_nacimiento
        ]);
    } else {
        echo json_encode(["error" => $conn->error]);
    }

    $sql->close();
}

$conn->close();
?>
