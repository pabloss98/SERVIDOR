<?php
$n=0;
for($i = 0; $i <=1; $i++){
    for($j = 0; $j <=2; $j++){
        $n++;
        $m[$i][$j] = $n;
    }
}
echo $m[1][2];
echo "<br>";
var_dump($m);
?>