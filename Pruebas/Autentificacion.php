<?php

$usu = "pepito";
$contraseña = "123";
$confirmacion = "123";

if($_POST["usuario"] == $usu){
    echo("El usuario es correcto");
}
echo "<br>";
if($_POST["password"] == $contraseña){
    echo("La contraseña es correcta");
}

echo "<br>";
if($_POST["confirmacion"] == $confirmacion){
    echo("La contraseña es correcta");
}


?>