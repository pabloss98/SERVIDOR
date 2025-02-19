<?php
$hn = "localhost"; 
$un = "root";      
$pw = "";          
$db = "diabetesdb"; 

$connection = new mysqli($hn, $un, $pw, $db);

if ($connection->connect_error) {
    die("Error de conexión: " . $connection->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
// Hipoglucemia
if (isset($_POST['glucosa']) && isset($_POST['hora'])) {
    $glucosa = $_POST['glucosa'];
    $hora = $_POST['hora'];
    $tipo_comida = $_POST['tipo_comida'];
    $fecha = $_POST['fecha'];

    $stmt = $connection->prepare("INSERT INTO hipoglucemia (glucosa, hora, tipo_comida, fecha) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $glucosa, $hora, $tipo_comida, $fecha);
    $stmt->execute();
    $stmt->close();
    }
}
$connection->close();
?>