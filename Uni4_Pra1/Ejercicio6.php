<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eje6</title>
</head>
<body>

    <form method="post">
        <label for="cantidad">Introduce el número de elementos a mostrar:</label>
        <input type="number" id="cantidad" name="cantidad" min="1" required>
        <button type="submit">ACEPTAR</button>
    </form>

    <?php
    $total = 0;
    $cantidad = 0;
    $valores = [];

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $cantidad = isset($_POST['cantidad']) ? (int)$_POST['cantidad'] : 0;

        for ($i = 0; $i <= $cantidad; $i++){
            $valores[$i] = isset($_POST["valor$i"]) ? (int)$_POST["valor$i"] : 0; 
            $total += $valores[$i];          
        }
           echo "<h3> La suma de los valores es: $total</h3>"; 
    }

    if ($cantidad > 0) {
        echo "<form method='post'>";
        
        // Mantener la cantidad en el nuevo formulario
        echo "<input type='hidden' name='cantidad' value='$cantidad'>";

        // Generar las cajas de texto para cada elemento
        for ($i = 0; $i < $cantidad; $i++) {
            $valor = isset($valores[$i]) ? $valores[$i] : '';
            echo "Valor " . ($i + 1) . ": <input type='number' name='valor$i' value='$valor'><br>";
        }

        // Botón para enviar los valores de los elementos
        echo "<button type='submit'>CALCULAR SUMA</button>";
        echo "</form>";
    }
    ?>


</body>
</html>