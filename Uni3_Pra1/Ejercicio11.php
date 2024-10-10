<?php

$peliculas = array(
    "Enero" => 9,
    "Febrero" => 12, 
    "Marzo" => 0, 
    "Abril" =>17
);

foreach($peliculas as $mes => $num){
    if($num != 0){
        echo "En el mes $mes se han visto $num peliculas <br>";
    }
}


?>