<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado de la Suma</title>
</head>
<body>
    <h1>Resultado</h1>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $num1 = $_POST['num1'];
        $num2 = $_POST['num2'];

        $suma = $num1 + $num2;

        echo "<p>La suma de $num1 y $num2 es: <strong>$suma</strong></p>";
    } else {
        echo "<p>No se recibieron los números correctamente.</p>";
    }
    ?>
    <br>
    <a href="Ej1.html">Volver al formulario</a>
</body>
</html>
