<?php

session_start();
if (isset($_POST["color"])){
    $_SESSION["color"] = $_POST["color"];
}

if (isset($_POST["color"])){
    $temColor = $_POST["temColor"];
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="circulo"></div>
    <form action="#" method="post">
        <input type="submit" value="red" name = "tempColor"> 
        <input type="submit" value="blue" name = "tempColor">
        <input type="submit" value="yellow" name = "tempColor">
        <input type="submit" value="green" name = "tempColor">
    </form>
</body>
</html>