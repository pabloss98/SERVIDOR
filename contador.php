<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario Simple</title>
</head>
<body>
    <h1>Formulario de Registro</h1>
   

    <?php
    session_start();
    $_SESSION['num']=$_POST['numero'];
    if (isset($_POST['sumar'])) {
        $_SESSION['num']++;
   echo $_SESSION['num'];
    } else
    if (isset($_POST['restar'])) {
        if ($_SESSION['num'] > 0) {
            $_SESSION['num']--;
        }
    } else {
        $numero = 0;
    }
    if(isset($_POST['enviar'])){
        session_destroy();
        header("Location: contador.php");
        }
    ?>
     <form action="contador.php" method="post">
        <input type="submit" name="restar" value="Restar">
        <input type="text" id="numero" name="numero" value="<?php echo $_SESSION['num']?>">
        <input type="submit" name="sumar" value="Sumar">
        <input type="submit" name="enviar" value="Enviar">
    </form>
</body>
</html>