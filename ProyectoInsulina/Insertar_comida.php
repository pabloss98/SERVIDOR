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
    // Comida
    if (isset($_POST['tipo_comida']) && isset($_POST['gl_1h']) && isset($_POST['gl_2h'])) {
        $tipo_comida = $_POST['tipo_comida'];
        $gl_1h = $_POST['gl_1h'];
        $gl_2h = $_POST['gl_2h'];
        $raciones = $_POST['raciones'];
        $insulina = $_POST['insulina'];
        $fecha = $_POST['fecha'];

        $stmt = $connection->prepare("INSERT INTO comida (tipo_comida, gl_1h, gl_2h, raciones, insulina, fecha) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("siisss", $tipo_comida, $gl_1h, $gl_2h, $raciones, $insulina, $fecha);
        $stmt->execute();
        $stmt->close();
    }

}

$connection->close();
?>