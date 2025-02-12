<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <title><?php echo $titulo; ?></title>
    <style>
       .form-container {
            width: 50%;
            margin: auto;
            margin-top: 10%;
            padding: 20px;
            border: 2px solid #ccc;
            border-radius: 10px;
            background-color: #f9f9f9;
        }
    </style>
    </head>
    <body>
        <div class="form-container">
        <form>
            <div class="form-group row">
                <label for="inputUsuario" class="col-sm-2 col-form-label">Usuario</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="inputUsuario" placeholder="Usuario">
                </div>
            </div>
            <br>
            <div class="form-group row">
                <label for="inputContraseña" class="col-sm-2 col-form-label">Contraseña</label>
                <div class="col-sm-10">
                <input type="password" class="form-control" id="inputContraseña" placeholder="Contraseña">
                </div>
            </div>
            <br>
            <div class="form-group row">
                <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                </div>
            </div>
        </form>
        </div>
    </body>
    </html>



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
