<?php
    $titulo = "Bienvenido";
    $login_url = "Login.php";
    $registro_url = "Registro.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 50px;
        }
        .container {
            max-width: 400px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
        }
        .button-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .button {
            display: block;
            width: 80%;
            padding: 10px;
            margin: 10px 0;
            text-decoration: none;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            font-size: 18px;
            text-align: center;
        }
        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><?php echo $titulo; ?></h1>
        <div class="button-container">
            <a href="<?php echo $login_url; ?>" class="button">Iniciar Sesión</a>
            <a href="<?php echo $registro_url; ?>" class="button">Registrarse</a>
        </div>
    </div>
</body>
</html>