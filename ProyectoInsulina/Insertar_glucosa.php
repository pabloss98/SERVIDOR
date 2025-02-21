<?php
session_start();

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
        $id = $_SESSION['Id'];

        $stmt = $connection->prepare("INSERT INTO control_glucosa (id_usu, fecha, deporte, lenta) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isii", $id, $fecha, $deporte, $lenta);
        $stmt->execute();
        $stmt->close();

        echo("Se han insertado los datos correctamente");
    }
}

$connection->close();
?>