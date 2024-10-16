<?php

include "Matematicas.php";

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