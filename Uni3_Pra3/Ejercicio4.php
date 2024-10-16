<?php

function nuevoarray($array, $limite){

    $resultado = array();

    foreach ($array as $numero) {
        if ($numero < $limite) {
            $resultado[] = $numero;
        }
    }

    return $resultado;
}

$arrayoriginal = [1,4,5,43,23,3,4,56,23,2];

$limite = 10;

$arrayfiltrado = nuevoarray($arrayoriginal, $limite);

echo "Array original ";
print_r($arrayoriginal);

echo"<br>";

echo "Nuevo array ";
print_r($arrayfiltrado);



?>