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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <a href="Formulario.html" class="btn btn-primary">Volver</a>
</body>
</html>