<?php

$horas = 49;
$paga = 20;
$total = 0;


if ($horas > 40){
    $total = $horas * $paga;
    $horas = $horas - 40;

    if($horas > 8){

        $horas = $horas - 8;
        $total = (($paga * 8) * 2) +$total;
        $total = (($paga * $horas) * 3) + $total;

    }
}

echo "El total a cobrar es " . $total;

?>