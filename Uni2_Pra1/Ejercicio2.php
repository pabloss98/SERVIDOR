<?php

$numeros = array(10, 25, 15);


$mayor = $numeros[0];


for ($i = 1; $i < count($numeros); $i++) {
    if ($numeros[$i] > $mayor) {
        $mayor = $numeros[$i];
    }
}


echo "El número mayor es: " . $mayor;
?>
