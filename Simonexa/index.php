<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <form  method="POST">
        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario" required>
        <br><br>
        <label for="contraseña">Contraseña:</label>
        <input type="password" id="contraseña" name="contraseña" required>
        <br><br>
        <button type="submit" name="Enviar">Enviar</button>
    </form>

    <?php
    session_start();
    $hn = "localhost"; 
    $un = "root";      
    $pw = "";          
    $db = "simon"; 

    
    $connection = new mysqli($hn, $un, $pw, $db);

    
    if ($connection->connect_error) {
        die("Error de conexión: " . $connection->connect_error);
    }

    
    if (isset($_POST["Enviar"])){
        
        $usuario = $_POST['usuario'];
        $password = $_POST['contraseña'];
        $_SESSION['usuario'] = $usuario;

        $select = "SELECT Nombre, Clave FROM usuarios WHERE Nombre = '$usuario' AND Clave = '$password'";
        $result = $connection->query($select);

        // Verificar si la consulta devolvió algún resultado
        if ($result->num_rows > 0) {
            
            header("Location: inicio.php");
        exit;
        } else {
            
            echo "<h1>Usuario o contraseña incorrectos, vuelve a intentarlo</h1>";
        }
    }

    // Cerrar la conexión
    $connection->close();
    ?>
</body>
</html>
