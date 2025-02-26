<?php
$hn = "localhost"; 
$un = "root";      
$pw = "";          
$db = "diabetesdb"; 

$connection = new mysqli($hn, $un, $pw, $db);

if ($connection->connect_error) {
    die("Error de conexión: " . $connection->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $fecha = $_POST['fecha_nacimiento'];

    // Verificar si el usuario ya existe
    $stmt = $connection->prepare("SELECT COUNT(*) FROM usuario WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        echo "<h1>El usuario ya existe. Por favor elige otro.</h1>";
    } else {
        //Si el usuario no existe procede a insertar el nuevo usuario
    $stmt = $connection->prepare("INSERT INTO usuario (usuario, contra, nombre, apellidos, fecha_nacimiento) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $usuario, $password, $nombre, $apellidos, $fecha);

    if($stmt->execute()){
        echo "<h1>¡$usuario, se ha registrado con éxito!</h1>";
        header("Location: Inicio.php");
        exit();
    } else {
        echo "<h1>Error al registrar usuario</h1>";
    }

    $stmt->close();
}
}
$connection->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Registro de Usuario</title>
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
        <form method="POST">
            <div class="form-group row">
                <label for="inputUsuario" class="col-sm-2 col-form-label">Usuario</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputUsuario" name="usuario" required>
                </div>
            </div>
            <br>
            <div class="form-group row">
                <label for="inputContraseña" class="col-sm-2 col-form-label">Contraseña</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="inputContraseña" name="password" required>
                </div>
            </div>
            <br>
            <div class="form-group row">
                <label for="inputNombre" class="col-sm-2 col-form-label">Nombre</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputNombre" name="nombre" required>
                </div>
            </div>
            <br>
            <div class="form-group row">
                <label for="inputApellidos" class="col-sm-2 col-form-label">Apellidos</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputApellidos" name="apellidos" required>
                </div>
            </div>
            <br>
            <div class="form-group row">
                <label for="inputFecha_nacimiento" class="col-sm-2 col-form-label">Fecha de nacimiento</label>
                <div class="col-sm-10">
                    <input type="date" class="form-control" id="inputFecha_nacimiento" name="fecha_nacimiento" required>
                </div>
            </div>
            <br>
            <div class="form-group row">
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">Registrarse</button>
                </div>
            </div>
            <a href="Inicio.php" class="btn btn-primary">Volver a inicio</a>
        </form>
    </div>
    
</body>
</html>
