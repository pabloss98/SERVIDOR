<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Círculo de Color Aleatorio</title>
    <style>
        /* Estilos para centrar el círculo y el botón en pantalla */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }

        /* Estilos del círculo */
        .circle {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            margin-bottom: 20px;
            
        }

        /* Estilos del botón */
        .play-button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            background-color: #333;
            color: #fff;
            transition: background-color 0.3s;
            margin:10px;
        }

        .play-button:hover {
            background-color: #555;
        }
    </style>
</head>
<body>

<?php
// Colores disponibles
$colores = ["yellow", "red", "blue", "green"];
// Selecciona un color aleatorio
$colorAleatorio = $colores[array_rand($colores)];
$colorAleatorio2 = $colores[array_rand($colores)];
$colorAleatorio3 = $colores[array_rand($colores)];
$colorAleatorio4 = $colores[array_rand($colores)];
?>

<!-- Div del círculo con el color aleatorio -->
<div class="circle" style="background-color: <?php echo $colorAleatorio; ?>;"></div>
<div class="circle" style="background-color: <?php echo $colorAleatorio2; ?>;"></div>
<div class="circle" style="background-color: <?php echo $colorAleatorio3; ?>;"></div>
<div class="circle" style="background-color: <?php echo $colorAleatorio4; ?>;"></div>


<!-- Botón de Jugar que recarga la página -->
<form method="POST">
    <button class="play-button" type="submit">Jugar</button>
</form>



</body>
</html>

