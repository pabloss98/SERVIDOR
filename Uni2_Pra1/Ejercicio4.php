<?php

$num1 = rand(1, 10);
$num2 = rand(1, 10);

$max = max($num1, $num2);
$tipo = $max % 2 ? "impar" : "par";

echo "El primer número aleatorio es: " . $num1;
echo "<br>";
echo "El segundo número aleatorio es: " . $num2;
echo "<br>";
echo "El mayor de los dos número es " . $max . " y es un número " . $tipo;

?>