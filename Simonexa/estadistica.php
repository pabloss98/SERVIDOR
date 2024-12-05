<?php session_start();
$usuario = $_SESSION['usuario'];?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simon</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Simon</h1>
    <h2><?= htmlspecialchars($usuario) ?> los resultados son: </h2>

    

    <a href="inicio.php">Volver a jugar</a>
</body>
</html>