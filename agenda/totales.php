<!DOCTYPE html>
<html>
<head>
    <title>TOTALES</title>
    <meta charset="UTF-8">
</head>
<body>
<?php
    session_start();
?>
<h2>AGENDA</h2>
<h3>Hola <?php echo $_SESSION['nombre'];?></h3>
<?php
$cadena_conexion = 'mysql:dbname=agenda;host=127.0.0.1';
$usuario = 'root';
$clave = '';

try {
    $bd = new PDO($cadena_conexion, $usuario, $clave);
    $bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT u.Codigo, u.Nombre, COUNT(c.codcontacto) AS NumContactos
            FROM usuarios u
            LEFT JOIN contactos c ON u.Codigo = c.codusuario
            GROUP BY u.Codigo, u.Nombre";
    $stmt = $bd->query($sql);

    echo "<table border='1'>";
    echo "<tr><th>Código usuario</th><th>Nombre</th><th>Número de Contactos</th><th>Gráfica</th></tr>";

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>{$row['Codigo']}</td>";
        echo "<td>{$row['Nombre']}</td>";
        echo "<td>{$row['NumContactos']}</td>";
        echo "<td>" . str_repeat('<div style="width: 10px; height: 10px; background-color: red; border-radius: 50%; margin: 2px; display: inline-block;"></div>', $row['NumContactos']) . "</td>";
        echo "</tr>";
    }

    echo "</table>";

} catch (PDOException $e) {
    die("Error de conexión a la base de datos: " . $e->getMessage());
}
?>

<br/>
<a href="index.php">Volver a loguearse</a>
<br/>
<a href="inicio.php">Introducir más contactos para <?php echo $_SESSION['nombre'];?> </a>

</body>
</html>
