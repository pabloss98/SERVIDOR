<?php

function es_primo($num) {
    if ($num < 2) {
        return false;
    }
    for ($i = 2; $i <= sqrt($num); $i++) {
        if ($num % $i == 0) {
            return false;
        }
    }
    return true;
}

$primos = array();
for ($numero = 1; $numero <= 50; $numero++) {
    if (es_primo($numero)) {
        $primos[] = $numero;
    }
}

echo "Los números primos entre 1 y 50 son: " . implode (",", $primos);

?>