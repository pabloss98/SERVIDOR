<?php

if( isset($_POST['opcion'])){
    $validar = $_POST['opcion'];

    switch ($validar){

        case "opcion1": 
            echo("Eres una personita");
            break;

        case "opcion2":
            echo("Todavía eres muy joven");
            break;

        case "opcion3":
            echo("Eres una persona joven");
            break;

        case "opcion4":
            echo("Eres una persona madura");
            break;

        case "opcion5":
            echo("Ya eres una persona mayor");
            break;

        default:
            echo("Aún no has dicho tu edad");
    }


}



?>