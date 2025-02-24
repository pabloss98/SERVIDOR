<?php
session_start();

// Verificar que el usuario esté logueado
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit;
}

$usuario = $_SESSION['usuario'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
</head>
<body>

    <h1>Bienvenido, <?php echo htmlspecialchars($usuario); ?></h1>

    <img src="20241212.jpg" alt="Jeroglífico del día">
    
    <form method="POST">
        <input type="text" name="respuesta" placeholder="Introduce tu solución" required><br>
        <button type="submit">Enviar respuesta</button>
    </form>

    <?php
    // Conexión a la base de datos
    $hn = "localhost";
    $un = "root";
    $pw = "";
    $db = "jerogrifico"; 

    $connection = new mysqli($hn, $un, $pw, $db);
    if ($connection->connect_error) {
        die("Error de conexión: " . $connection->connect_error);
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $respuesta = $_POST['respuesta'];
        $fecha = date('Y-m-d');
        $hora = date('H:i:s');
        
        // Guardar la respuesta en la base de datos
        $query = "INSERT INTO respuestas (login, respuesta, fecha, hora) VALUES ('$login', '$respuesta', '$fecha', '$hora')";
        if ($connection->query($query)) {
            echo "Respuesta guardada exitosamente.";
        } else {
            echo "Error al guardar la respuesta: " . $connection->error;
        }
    }

    $connection->close();
    ?>

    <br><br>
    <a href="resultado.php">Resultados del día</a><br>
    <a href="puntos.php">Ver puntos por jugador</a>

</body>
</html>
