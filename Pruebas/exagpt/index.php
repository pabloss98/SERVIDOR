<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
</head>
<body>

    <h1>Iniciar sesión</h1>
    <form method="POST">
        <label for="login">Usuario:</label>
        <input type="text" id="login" name="login" required>
        <br><br>
        <label for="contraseña">Contraseña:</label>
        <input type="password" id="contraseña" name="contraseña" required>
        <br><br>
        <button type="submit" name="Enviar">Enviar</button>
    </form>

    <?php
    session_start();
    
    // Parámetros de la base de datos
    $hn = "localhost";
    $un = "root";
    $pw = "";
    $db = "jerogrifico"; 

    // Conexión a la base de datos
    $connection = new mysqli($hn, $un, $pw, $db);

    if ($connection->connect_error) {
        die("Error de conexión: " . $connection->connect_error);
    }

    // Validación de login y contraseña
    if (isset($_POST["Enviar"])) {
        $login = $_POST['login'];
        $password = $_POST['contraseña'];
        $_SESSION['login'] = $login;

        // Consulta SQL para verificar el login
        $select = "SELECT login, clave FROM jugador WHERE login = '$login' AND clave = '$password'";
        $result = $connection->query($select);

        if ($result->num_rows > 0) {
            // Redirigir a la página de inicio
            header("Location: inicio.php");
            exit;
        } else {
            // Mostrar mensaje de error
            echo "<h3>Credenciales incorrectas. Inténtalo de nuevo.</h3>";
        }
    }

    // Cerrar la conexión
    $connection->close();
    ?>

</body>
</html>
