<?php

$pares = array();

for($i=1; $i<=10; $i++){
    $pares[] = $i * 2; 
}

foreach($pares as $numero){
    echo $numero . "<br>";
}
?>