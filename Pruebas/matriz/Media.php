<?php

$a = array(10, 20, 30, 40, 50);
$valores = count(value: $a);
$suma = 0;
$media = 0;

for ($i = 0; $i < $valores; $i++){
    $suma += $a[$i];
}
    
$media = $suma / $valores;
echo $media;


?>