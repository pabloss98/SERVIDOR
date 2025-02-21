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
// Hiperglucemia
if (isset($_POST['glucosa']) && isset($_POST['hora']) && isset($_POST['correccion'])) {
    $glucosa = $_POST['glucosa'];
    $hora = $_POST['hora'];
    $correccion = $_POST['correccion'];
    $tipo_comida = $_POST['tipo_comida'];
    $fecha = $_POST['fecha'];
    $id = $_SESSION['Id'];

    $stmt = $connection->prepare("INSERT INTO hiperglucemia (id_usu, glucosa, hora, correccion, tipo_comida, fecha) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iissss", $id, $glucosa, $hora, $correccion, $tipo_comida, $fecha);
    $stmt->execute();
    $stmt->close();

    echo("Se han insertado los datos correctamente");
    }
}
$connection->close();
?>