<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mostrar Elementos Dinámicamente</title>
</head>
<body>
    <?php
    $cantidad = 0;
    $total = 0;
    $valores = [];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $cantidad = isset($_POST['cantidad']) ? (int)$_POST['cantidad'] : 0;

        for ($i = 0; $i < $cantidad; $i++) {
            $valores[$i] = isset($_POST["valor$i"]) ? (int)$_POST["valor$i"] : 0;
            $total += $valores[$i]; // Sumar al total
        }

        if ($cantidad > 0) {
            echo "<h3>La suma de los valores es: $total</h3>";
        }
    }
    ?>

    <form method="post">
        <label for="cantidad">Introduce el número de elementos a mostrar:</label>
        <input type="number" id="cantidad" name="cantidad" min="1" value="<?php echo $cantidad; ?>" required>
        <button type="submit">ACEPTAR</button>
    </form>

    <?php
    if ($cantidad > 0) {
        echo "<form method='post'>";
        
        echo "<input type='hidden' name='cantidad' value='$cantidad'>";

        for ($i = 0; $i < $cantidad; $i++) {
            $valor = isset($valores[$i]) ? $valores[$i] : '';
            echo "Valor " . ($i + 1) . ": <input type='number' name='valor$i' value='$valor'><br>";
        }

        echo "<button type='submit'>CALCULAR SUMA</button>";
        echo "</form>";
    }
    ?>
</body>
</html>
