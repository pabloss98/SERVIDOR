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
    <label for="confirmacion">Confirmar Contraseña:</label>
    <input type="password" id="confirmacion" name="confirmacion"  required>
    <br><br>
    <button type="submit" >Enviar</button>

    </form>
</body>
</html>