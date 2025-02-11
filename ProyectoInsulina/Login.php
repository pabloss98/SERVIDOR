<?php
session_start();

$hn = "localhost"; 
$un = "root";      
$pw = "";          
$db = "diabetesdb"; 


$connection = new mysqli($hn, $un, $pw, $db);


if ($connection->connect_error) {
    die("Error de conexión: " . $connection->connect_error);
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST["login"];
    $clave = $_POST["clave"];

    $select = "SELECT nombre, clave FROM jugador WHERE nombre = '$login' AND clave = '$clave'";
    $result = $connection->query($select);

    if (autenticarUsuario($login, $clave)) {
        // Usuario autenticado, establecer la sesión y redirigir a la página principal
        $_SESSION["login"] = $login;
        header("Location: Insercion.php");
        exit();
    } else {
        // Usuario no autenticado, mostrar mensaje de error
        $error = "Credenciales incorrectas. Inténtalo de nuevo.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
</head>
<body>

    <h2>Iniciar sesión</h2>

    <?php if(isset($error)) { ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php } ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="login">Usuario:</label>
        <input type="text" id="login" name="login" required><br>

        <label for="clave">Contraseña:</label>
        <input type="password" id="clave" name="clave" required><br>

        <input type="submit" value="Entrar">
    </form>

</body>
</html>
