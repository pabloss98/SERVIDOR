<?php

function palindromo($cadena){

    if ($cadena == strrev($cadena)){
        return true;
    }else {
        return false;
    }
}

$cadena1 = "ala";
$cadena2 = "hola";

if (palindromo($cadena1)){
    echo "$cadena1 Es un palindromo";
}else{
    echo "$cadena1 No es un palindromo";
}

echo "<br>";

if (palindromo($cadena2)){
    echo "$cadena2 Es un palindromo";
}else{
    echo "$cadena2 No es un palindromo";
}


?>