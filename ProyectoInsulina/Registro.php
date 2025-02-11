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
    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="nombre"  required>
    <br><br>
    <label for="apellidos">Apellidos:</label>
    <input type="text" id="apellidos" name="apellidos"  required>
    <br><br>
    <label for="nombre">Fecha de nacimiento :</label>
    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento"  required>
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
        $password = $_POST['password'];
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $fecha = $_POST['fecha_nacimiento'];

        $stmt = $connection->prepare("INSERT INTO usuario (usuario, contra, nombre, apellidos, fecha_nacimiento) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $usuario, $password, $nombre, $apellidos, $fecha);

        if ($result->num_rows > 0) {
            
            echo "<h1>¡$usuario, se ha registrado!</h1>";
        } else {
            
            echo "<h1>Usuario o contraseña incorrectos</h1>";
        }
        $stmt->close();
    }
    $connection->close();
    ?>
</body>
</html>