<?php
$num1 = "";
$num2 = "";
$resultado = "";
$operacion = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $num1 = isset($_POST['num1']) ? $_POST['num1'] : "";
    $num2 = isset($_POST['num2']) ? $_POST['num2'] : "";
    $operacion = isset($_POST['operacion']) ? $_POST['operacion'] : "";

    if (is_numeric($num1) && is_numeric($num2)) {
        switch ($operacion) {
            case "sumar":
                $resultado = $num1 + $num2;
                break;
            case "restar":
                $resultado = $num1 - $num2;
                break;
            case "multiplicar":
                $resultado = $num1 * $num2;
                break;
            case "dividir":
                if ($num2 != 0) {
                    $resultado = $num1 / $num2;
                } else {
                    $resultado = "Error: No se puede dividir por cero.";
                }
                break;
            default:
                $resultado = "Operación no válida.";
        }
    } else {
        $resultado = "Por favor, ingresa números válidos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora PHP</title>
</head>
<body>
    <h1>Calculadora</h1>

    <?php if ($resultado !== ""): ?>
        <p>Resultado: <strong><?php echo $resultado; ?></strong></p>
    <?php endif; ?>

    <form method="post" action="">
        <label for="num1">Número 1:</label>
        <input type="text" id="num1" name="num1" value="<?php echo $num1; ?>" required>
        <br><br>

        <label for="num2">Número 2:</label>
        <input type="text" id="num2" name="num2" value="<?php echo $num2; ?>" required>
        <br><br>

        <label>Operación:</label><br>
        <button type="submit" name="operacion" value="sumar">Sumar</button>
        <button type="submit" name="operacion" value="restar">Restar</button>
        <button type="submit" name="operacion" value="multiplicar">Multiplicar</button>
        <button type="submit" name="operacion" value="dividir">Dividir</button>
    </form>
</body>
</html>
