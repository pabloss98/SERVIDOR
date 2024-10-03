<?php

$numero = rand(1, 100);

$primo = true;

if ($numero == 1){
    $primo = false;
}else{
    for ($i= 2; $i<=$numero/2; $i++){
        if($numero % $i == 0){
            $primo = false;
    }
}
}
if ($primo){
    echo "$numero es primo";
}else {
    echo "$numero no es primo";
}

?>