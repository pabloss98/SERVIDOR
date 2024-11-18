<!DOCTYPE html>
<html>
<body>

<?php
$sexo = $sexoErr = ""; // Inicializar variables

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["sexo"])) {
        $sexoErr = "El sexo es obligatorio";
    } else {
        $sexo = $_POST["sexo"];
    }
}
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Sexo:
    <input type="radio" name="sexo" <?php if (isset($sexo) && $sexo=="mujer") echo "checked";?> value="mujer"> Mujer
    <input type="radio" name="sexo" <?php if (isset($sexo) && $sexo=="hombre") echo "checked";?> value="hombre"> Hombre
    <span class="error">* <?php echo $sexoErr;?></span>
    <br><br>
    <input type="submit" value="Enviar">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($sexo)) {
    echo "Has seleccionado: " . $sexo;
}
?>

</body>
</html>
