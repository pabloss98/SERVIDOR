<!DOCTYPE html>
<html>
<body>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Procesar los datos del formulario
    $nombre = htmlspecialchars($_POST['nombre']);
    echo "Hola, " . $nombre;
}
?>

<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    Nombre: <input type="text" name="nombre">
    <input type="submit" value="Enviar">
</form>

</body>
</html>
