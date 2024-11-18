<?php

$valor = "    Es tu nombre O\'reilly?     "; 

function test_entrada($valor) { 
        $valor = trim($valor);
        $valor = stripslashes($valor);
        return $valor; 
    } 

    echo test_entrada($valor);

?>