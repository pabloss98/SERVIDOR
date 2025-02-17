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
    $password = $_POST["password"];

    var_dump($_POST); // Verifica si los datos llegan bien

    // Preparar la consulta para evitar inyección SQL
    $stmt = $connection->prepare("SELECT nombre, contra FROM usuario WHERE nombre = ?");
    if (!$stmt) {
        die("❌ Error en la preparación de la consulta: " . $connection->error);
    }

    $stmt->bind_param("s", $login);
    $stmt->execute();
    $result = $stmt->get_result();

    var_dump($result->num_rows); // Verifica si la consulta devuelve algo

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        var_dump($row); // Verifica si la consulta obtiene datos

        // Si las contraseñas NO están hasheadas, usa comparación simple
        if ($password === $row['contra']) {
            $_SESSION["login"] = $login;
            header("Location: Insercion.php");
            exit();
        } else {
            $error = "Credenciales incorrectas. Inténtalo de nuevo.";
        }
    } else {
        $error = "Credenciales incorrectas. Inténtalo de nuevo.";
    }

    $stmt->close();
}

$connection->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Iniciar Sesión</title>
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
                    <input type="text" class="form-control" id="inputUsuario" name="login" placeholder="Usuario" required>
                </div>
            </div>
            <br>
            <div class="form-group row">
                <label for="inputContraseña" class="col-sm-2 col-form-label">Contraseña</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="inputContraseña" name="password" placeholder="Contraseña" required>
                </div>
            </div>
            <br>
            <div class="form-group row">
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                </div>
            </div>
        </form>

        <!-- Mostrar mensaje de error si las credenciales son incorrectas -->
        <?php if (isset($error)) { ?>
            <div class="alert alert-danger mt-3"><?php echo $error; ?></div>
        <?php } ?>
    </div>
</body>
</html>
