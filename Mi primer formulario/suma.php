<?php

    echo $_POST['numero1'];
    echo "<br>";
    echo $_POST['numero2'];
    echo "<br>";
   
    echo "El resultado de la suma de los dos numeros es = " . $_POST['numero1'] + $_POST['numero2'];

    var_dump($_SERVER['HTTP_SEC_CH_UA']);
?>