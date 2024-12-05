<?php
    session_start();
    $_SESSION["contador"]++;
    for($i = 0; $i<6;$i++ ){
        $_SESSION["negras"][$i]="boca_abajo.jpg";
    }
    $_SESSION["negras"][$_POST["boton"]]=$_SESSION["cartas"][$_POST["boton"]];
    header("Location: mostrarcartas.php");
    exit;
?>