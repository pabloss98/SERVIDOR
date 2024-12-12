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
        <?php
        session_start();
        $usuario = $_SESSION['usuario'];
        echo "Bienvenido, ". $usuario. "!";
        echo "<br>";
        echo "<h1>JEROGLÍFICO</h1>";
        echo "<br>";
        
        $imagen = ["img/20241212.jpg"];
        echo "<img src='{$imagen}' ><br>";
        echo "<br>";
        echo "Todos hablan de la fiesta de ayer";
        ?>
        <br><br>
        <label for="resp">Solución al jeroglifico</label>
        <input type="text" name="resp" required>
        <input type="submit" value="Vamos a Jugar" name='Enviar'>
    </form>
    <a href="puntos.php">Ver puntos por jugador</a>
    <br>
    <a href="resultado.php">Resultados por dia</a>
    
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $usuario = $_POST['usuario'];
        $password = $_POST['contraseña'];

        $select = "INSERT INTO respuestas (respuestas) VALUES (respuestas)";
        $result = $connection->query($select);

    }

    ?>
</body>
</html>