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
    // Comida
    if (isset($_POST['tipo_comida']) && isset($_POST['gl_1h']) && isset($_POST['gl_2h'])) {
        $tipo_comida = $_POST['tipo_comida'];
        $gl_1h = $_POST['gl_1h'];
        $gl_2h = $_POST['gl_2h'];
        $raciones = $_POST['raciones'];
        $insulina = $_POST['insulina'];
        $fecha = $_POST['fecha'];
        $id = $_SESSION['Id'];

        // Verificar si existe un registro en control_glucosa para esta fecha y usuario
        $check = $connection->prepare("SELECT * FROM control_glucosa WHERE fecha = ? AND id_usu = ?");
        $check->bind_param("si", $fecha, $id);
        $check->execute();
        $result = $check->get_result();
        
        // Verificar si hay resultados
        if ($result->num_rows > 0) {
            $stmt = $connection->prepare("INSERT INTO comida (id_usu, tipo_comida, gl_1h, gl_2h, raciones, insulina, fecha) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("isiisss", $id, $tipo_comida, $gl_1h, $gl_2h, $raciones, $insulina, $fecha);
            
            if ($stmt->execute()) {
                echo("Se han insertado los datos correctamente");
            } else {
                echo "Error: ". $stmt->error . "<br>";
            }
            $stmt->close();
        } else {
            echo '<script>alert("Inserte primero control glucosa"); window.location.href="Formulario.html";</script>';
        }
        
        $check->close();
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
