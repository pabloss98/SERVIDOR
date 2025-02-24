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

// Consulta para obtener los jugadores y sus puntos
$query = "SELECT nombre, puntos FROM jugador ORDER BY puntos DESC";

$result = $connection->query($query);

$connection->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Puntos por Jugador</title>
</head>
<body>

    <h1>Puntos acumulados por jugadores</h1>

    <table border="1">
        <tr>
            <th>Jugador</th>
            <th>Puntos</th>
        </tr>

        <?php
        // Mostrar los resultados en una tabla
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>" . htmlspecialchars($row['nombre']) . "</td><td>" . $row['puntos'] . "</td></tr>";
            }
        } else {
            echo "<tr><td colspan='2'>No hay jugadores registrados</td></tr>";
        }
        ?>

    </table>

</body>
</html>
