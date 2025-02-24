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

// Obtener las respuestas del día, incluyendo el login y la hora
$fecha = date('Y-m-d');

// Usar una consulta preparada para evitar la inyección de SQL
$query = "SELECT login, respuesta, fecha, hora FROM respuestas WHERE fecha = ?";
$stmt = $connection->prepare($query);

// Vincular el parámetro de la consulta
$stmt->bind_param("s", $fecha); // "s" indica que el parámetro es una cadena (string)
$stmt->execute();

if (!$stmt->execute()) {
    die("Error en la consulta: " . $stmt->error);
}

// Obtener el resultado de la consulta
$result = $stmt->get_result();

$aciertos = 0;
$fallos = 0;

if ($result->num_rows > 0) {
    // Contabilizar aciertos y fallos
    while ($row = $result->fetch_assoc()) {
        if (isset($row['respuesta']) && $row['respuesta'] == 'respuesta_correcta') {  // Aquí deberías reemplazar por la validación real
            $aciertos++;
        } else {
            $fallos++;
        }
    }
} else {
    echo "No se encontraron resultados para el día de hoy.";
}

// No cerramos la declaración aún, ya que la necesitamos más adelante

?>

<!DOCTYPE html>
<html>
<head>
    <title>Resultados</title>
</head>
<body>
    <h1>Resultados del día <?php echo $fecha; ?></h1>
    <p>Jugadores acertantes: <?php echo $aciertos; ?></p>
    <p>Jugadores que han fallado: <?php echo $fallos; ?></p>

    <h2>Respuestas del día:</h2>
    <table border="1">
        <tr>
            <th>Login</th>
            <th>Respuesta</th>
            <th>Hora</th>
        </tr>

        <?php
        // Ahora mostramos los resultados sin cerrar la declaración
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['login']) . "</td>";
                echo "<td>" . htmlspecialchars($row['respuesta']) . "</td>";
                echo "<td>" . htmlspecialchars($row['hora']) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No hay respuestas para hoy</td></tr>";
        }
        ?>
    </table>

    <?php
    // Ahora cerramos la declaración y la conexión
    $stmt->close();
    $connection->close();
    ?>

</body>
</html>
