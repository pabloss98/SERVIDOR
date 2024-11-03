<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario con Suma</title>
</head>
<body>
    <?php
    $total = 0;
    $valores = [];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        for ($i = 0; $i < 9; $i++) {
            $valores[$i] = isset($_POST["valor$i"]) ? (int)$_POST["valor$i"] : 0;
            $total += $valores[$i]; // Sumar al total
        }
        
        echo "<h3>La suma de los valores es: $total</h3>";
    }
    ?>

    <form method="post">
        <?php
        for ($i = 0; $i < 9; $i++) {
            $valor = isset($valores[$i]) ? $valores[$i] : '';
            echo "Valor " . ($i + 1) . ": <input type='number' name='valor$i' value='$valor'><br>";
        }
        ?>
        <button type="submit">ENVIAR</button>
    </form>
</body>
</html>
