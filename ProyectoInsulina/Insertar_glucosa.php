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
// Glucosa
    if (isset($_POST['deporte']) && isset($_POST['lenta'])) {
        $fecha = $_POST['fecha'];
        $deporte = $_POST['deporte'];
        $lenta = $_POST['lenta'];

        $stmt = $connection->prepare("INSERT INTO glucosa (fecha, deporte, insulina_lenta) VALUES (?, ?, ?)");
        $stmt->bind_param("sii", $fecha, $deporte, $lenta);
        $stmt->execute();
        $stmt->close();
    }
}

$connection->close();
?>