<?php

$num1 = rand(1, 10);
$num2 = rand(1, 10);

echo "El primer numero es " . $num1;
echo "<br>";
echo "El segundo numero es " . $num2;
echo "<br>";

if ($num1 == $num2) {
   $multi =  $num1 * $num2;
    echo "El resultado es " . $multi;
    }   
        else if($num1 > $num2 ){
         $resta = $num1 - $num2;
         echo "El resultado es " . $resta;
        }
            else {
                $suma = $num1 + $num2;
                echo "El resultado es " . $suma;
            }

?>