<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <form action="" method="POST">
        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario" required>
        <br><br>
        <label for="contraseña">Contraseña:</label>
        <input type="password" id="contraseña" name="contraseña" required>
        <br><br>
        <button type="submit">Enviar</button>
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

        $select = "SELECT usu, contraseña FROM usuarios WHERE usu = '$usuario' AND contraseña = '$password'";
        $result = $connection->query($select);

        // Verificar si la consulta devolvió algún resultado
        if ($result->num_rows > 0) {
            
            echo "<h1>¡Bienvenido, $usuario!</h1>";
        } else {
            
            echo "<h1>Usuario o contraseña incorrectos</h1>";
            echo "<a href= 'Registro.php'>Registrate</a>";
        }
    }

    // Cerrar la conexión
    $connection->close();
    ?>
</body>
</html>
