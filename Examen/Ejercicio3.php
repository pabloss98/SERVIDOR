<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php

    $num = rand(1,100);
    $valor = $_POST["valor"];

    if ($valor == $num){
        echo "has acertado";
    }else if($valor < $num){
        echo "el numero a adivinar es mayor";
    }else{
        echo "el numero a adivinar es menor";
    }

    ?>

<form method="post">
        <?php

          
           // $valor = isset($valores[$i]) ? $valores[$i] : '';
            echo "Adivina mi numero : <input type='number' name='valor' value='$valor'><br>";
       
            //echo "Adivina mi numero: <input type= 'number' name = 'valor' value = '$valor' "; 
            
            
        
        ?>
        <button type="submit">CALCULAR</button>
    </form>
</body>
</html>