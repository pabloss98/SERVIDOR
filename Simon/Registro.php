<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="Autenticacion.php" method="POST">

    <label for="usuario">Usuario:</label>
    <input type="text" id="usuario" name="usuario" required>
    <br><br>
    <label for="contraseña">Contraseña:</label>
    <input type="password" id="password" name="password"  required>
    <br><br>
    <label for="confirmacion">Confirmar Contraseña:</label>
    <input type="password" id="confirmacion" name="confirmacion"  required>
    <br><br>
    <button type="submit" >Enviar</button>

    </form>


    <?php

    $hn = "localhost"; 
    $un = "root";      
    $pw = "";          
    $db = "bede_simon"; 

    $connection = new mysqli($hn, $un, $pw, $db);

        
    if ($connection->connect_error) {
        die("Error de conexión: " . $connection->connect_error);
    }


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $usuario = $_POST['usuario'];
        $password = $_POST['contraseña'];

        $insertar="INSERT INTO usuarios(usu, contraseña, rol) VALUES ('yolanda', 'yolanda', 'Jugador')";
        $connection->query($insertar);

        if ($result->num_rows > 0) {
            
            echo "<h1>¡$usuario, se ha registrado!</h1>";
        } else {
            
            echo "<h1>Usuario o contraseña incorrectos</h1>";
        }
    }
    ?>
</body>
</html>