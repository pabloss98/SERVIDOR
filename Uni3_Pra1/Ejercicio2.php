<?php

$alumnos = array(

    "basico " => array(1, 14, 8, 3),
    "medio " => array (6, 19, 7, 2),
    "perfeccionamiento " => array(3, 13, 4, 1)
);

foreach($alumnos as $nivel => $numero){
    echo "Nivel $nivel<br>";
    echo "Ingles $numero[0]<br>";
    echo "Frances $numero[1]<br>";
    echo "Aleman $numero[2]<br>";
    echo "Ruso $numero[3]<br>";
}


?>