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
                <label for="inputNombre" class="col-sm-2 col-form-label">Nombre</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="inputNombre" placeholder="Nombre">
                </div>
            </div>
            <br>
            <div class="form-group row">
                <label for="inputApellidos" class="col-sm-2 col-form-label">Apellidos</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="inputApellidos" placeholder="Apellidos">
                </div>
            </div>
            <br>
            <div class="form-group row">
                <label for="inputFecha_nacimiento" class="col-sm-2 col-form-label">Fecha de nacimiento</label>
                <div class="col-sm-10">
                <input type="date" class="form-control" id="inputFecha_nacimiento" placeholder="">
                </div>
            </div>
            <br>
            <div class="form-group row">
                <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Registrarse</button>
                </div>
            </div>
            </form>
            </div>
    </body>
    </html>


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