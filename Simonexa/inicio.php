<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simon</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="jugar.php" method="post">
        <h1>Memoriza los colores</h1>
        <?php
        session_start();
        $usuario = $_SESSION['usuario'];
        echo "Hola ". $usuario. " memoriza la combinación";
        echo "<br>";
        echo "<br>";
            require_once "pintar-circulos.php";
            $colors=["red","green","blue","yellow"];
            pintar_circulos($colors[array_rand($colors)],$colors[array_rand($colors)],$colors[array_rand($colors)],$colors[array_rand($colors)]);
        
        ?>
        <br><br>
        <input type="submit" value="Vamos a Jugar" name='jugar'>
    </form>
</body>
</html>