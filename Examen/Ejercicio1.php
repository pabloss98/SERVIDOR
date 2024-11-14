<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario con Suma</title>
</head>
<body>
    <?php
    
    //$num = 0;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        for ($i = 0; $i < 2; $i++) {
            for ($j = 1; $j < 3; $j++){
                $num[$i][$j] = $_POST[$i][$j];
                echo "E" . $num[$i][$j]. ": <input type= 'number' name = '$i' value = '$num[$i][$j]' "; 

            }
            
        }
    }
    ?>

    <form method="post">
        <?php

        $num[0][0];    

        for ($i = 0; $i < 2; $i++) {
            for ($j = 1; $j < 3; $j++){
                $num[$i][$j] = $_POST[$i][$j];
                echo "E" . $num[$i][$j]. ": <input type= 'number' name = '$i' value = '$num[$i][$j]' "; 
            }
            
        }
        ?>
        <button type="submit">CALCULAR</button>
    </form>
</body>
</html>