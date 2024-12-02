<?php session_start()?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acierto</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Mirar en casa-->
    <h1>Simon</h1>
    <h2>Has fallado <?php $usuario;></h2>
    <p>La combinacion era: </p>
    <?php
        $usuario = $_SESSION['usuario'];
        echo $usuario;
        echo "<br>";
        echo "<br>";
        include "pintar-circulos.php";
        pintar_circulos($_SESSION['circulo1'],$_SESSION['circulo2'],$_SESSION['circulo3'],$_SESSION['circulo4']);
    ?>
    <p>Y tu combinacion fue: </p>
    <?php
        pintar_circulos($_SESSION['resp1'],$_SESSION['resp2'],$_SESSION['resp3'],$_SESSION['resp4']);
    ?>
    <a href="index.php">Volver a jugar</a>
</body>
</html>