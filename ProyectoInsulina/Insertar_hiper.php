<?php
session_start();

$hn = "fdb1028.awardspace.net";
$un = "4597186_diabetesdb";
$pw = "insulina123";
$db = "4597186_diabetesdb"; 

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

        // Verificar si existe un registro en control_glucosa para esta fecha y usuario
        $check_glucosa = $connection->prepare("SELECT 1 FROM control_glucosa WHERE fecha = ? AND id_usu = ?");
        $check_glucosa->bind_param("si", $fecha, $id);
        $check_glucosa->execute();
        $result_glucosa = $check_glucosa->get_result();
        
        // Verificar si existe un registro en comida para esta fecha, tipo_comida y usuario
        $check_comida = $connection->prepare("SELECT 1 FROM comida WHERE fecha = ? AND tipo_comida = ? AND id_usu = ?");
        $check_comida->bind_param("ssi", $fecha, $tipo_comida, $id);
        $check_comida->execute();
        $result_comida = $check_comida->get_result();
        
        // Verificar si hay resultados en ambas tablas
        if ($result_glucosa->num_rows > 0 && $result_comida->num_rows > 0) {
            $stmt = $connection->prepare("INSERT INTO hiperglucemia (id_usu, glucosa, hora, correccion, tipo_comida, fecha) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("iisiss", $id, $glucosa, $hora, $correccion, $tipo_comida, $fecha);
            
            if ($stmt->execute()) {
                echo("Se han insertado los datos correctamente");
            } else {
                echo "Error: ". $stmt->error . "<br>";
            }
            $stmt->close();
        } else {
            if ($result_glucosa->num_rows == 0 && $result_comida->num_rows == 0) {
                echo '<script>
                    alert("Debe insertar primero control de glucosa y comida para esta fecha");
                    window.location.href="Formulario.html";
                </script>';
            } else if ($result_glucosa->num_rows == 0) {
                echo '<script>
                    alert("Debe insertar primero control de glucosa para esta fecha");
                    window.location.href="Formulario.html";
                </script>';
            } else {
                echo '<script>
                    alert("Debe insertar primero comida para esta fecha y tipo de comida");
                    window.location.href="Formulario.html";
                </script>';
            }
        }
        
        $check_glucosa->close();
        $check_comida->close();
    }
}

$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Hiperglucemia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <a href="Formulario.html" class="btn btn-primary">Volver</a>
    </div>
</body>
</html>
