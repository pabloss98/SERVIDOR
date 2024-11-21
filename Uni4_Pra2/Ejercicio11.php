<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method = "POST">
    <label for="name">Nombre:</label>
    <input type="text" id="name" name="name" required>
    <br><br>
    <label for="email">Email:</label>
    <input type="text" id="email" name="email"  required>
    <br><br>
    <input type="radio" id="hombre" name="genero" value="Hombre" required>
        <label for="hombre">Hombre</label><br>
        <input type="radio" id="mujer" name="genero" value="Mujer" required>
        <label for="mujer">Mujer</label><br>
        <br>
    <button type="submit" >Enviar</button>
    </form>
</body>
</html>