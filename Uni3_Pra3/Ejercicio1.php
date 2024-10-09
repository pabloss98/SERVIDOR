<?php
function resolverEcuacionSegundoGrado($a, $b, $c) {
   
    $discriminante = $b**2 - 4 * $a * $c;

    
    if ($discriminante < 0) {
        return false;
    }

    
    if ($discriminante == 0) {
        $solucion = -$b / (2 * $a);
        return [$solucion];
    }

    
    $solucion1 = (-$b + sqrt($discriminante)) / (2 * $a);
    $solucion2 = (-$b - sqrt($discriminante)) / (2 * $a);
    
    return [$solucion1, $solucion2];
}


$a = 1;
$b = -3;
$c = 2;
$resultado = resolverEcuacionSegundoGrado($a, $b, $c);

if ($resultado === false) {
    echo "No hay soluciones reales.";
} else {
    echo "Las soluciones son: " . implode(", ", $resultado);
}
?>

