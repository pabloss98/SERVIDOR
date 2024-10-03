<?php

$m = array (array(2,4,6,8),
            array(4,6,2,4),
            array(1,3,2,5),
            array(6,6,8,3));

for ($i = 0; $i <4; $i++){
    $suma+=$m[$i][$i];

    $suma1+=$m[3-$i][$i];
}

echo $suma;
echo "<br>";
echo $suma1;
?>