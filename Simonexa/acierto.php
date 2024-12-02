<?php session_start();
$usuario = $_SESSION['usuario'];?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acierto</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Simon</h1>
    <h2><?= htmlspecialchars($usuario) ?> enhorabuena, has acertado todos los circulos </h2>
    <?php
        include "pintar-circulos.php";
        pintar_circulos($_SESSION['resp1'],$_SESSION['resp2'],$_SESSION['resp3'],$_SESSION['resp4']);
    ?>
    <a href="inicio.php">Volver a jugar</a>
</body>
</html>