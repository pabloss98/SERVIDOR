<?php

$a = 1; 
$b = -3; 
$c = 2; 

$discriminante = ($b * $b) - (4 * $a * $c);


if ($discriminante < 0) {

    echo "No hay soluciones reales.";
} elseif ($discriminante == 0) {
    
    $solucion = -$b / (2 * $a);
    echo "Hay una única solución: x = " . $solucion;
} else {
    
    $solucion1 = (-$b + sqrt($discriminante)) / (2 * $a);
    $solucion2 = (-$b - sqrt($discriminante)) / (2 * $a);
    echo "Hay dos soluciones: x1 = " . $solucion1 . " y x2 = " . $solucion2;
}
?>


