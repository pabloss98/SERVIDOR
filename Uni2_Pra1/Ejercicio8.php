<?php

$num = rand(1, 1000);

$sum = 1;

for($i = 2; $i < $num; $i++){
    if($num % $i == 0) {
        $sum += $i;
    }
}

if($sum == $num){
    echo "$num es un numero perfecto.";
} else{
    echo "$num no es un numero perfecto.";


}


?>