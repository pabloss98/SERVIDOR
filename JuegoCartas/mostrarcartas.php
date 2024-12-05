<?php
session_start();
$login = $_SESSION['login'];
if(!isset($_SESSION["contador"])){
    $_SESSION["contador"]=0;
$_SESSION["resul"] = 0;
$negras=["boca_abajo.jpg", "boca_abajo.jpg", "boca_abajo.jpg", "boca_abajo.jpg", "boca_abajo.jpg", "boca_abajo.jpg"];
$bin = ["copas_02.jpg","copas_02.jpg","copas_03.jpg","copas_03.jpg", "copas_05.jpg", "copas_05.jpg"];
shuffle($bin);
$_SESSION["cartas"]=$bin;
$_SESSION["negras"]=$negras;

}

?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Document</title>
<style>
    img{
        width:150px;
        height:250px;
        margin:0px 10px;
    }
</style>
</head>
<body>
<h1>Adivina el numero decimal</h1>
<h2>Bienvenid@ <?= htmlspecialchars($login) ?></h2>
<h2>Cartas levantadas</h2>
<form method = "POST" action= "comprobar.php">
    <button type="submit" name="boton" value="0">Carta1 </button>
    <button type="submit" name="boton" value="1">Carta2 </button>
    <button type="submit" name="boton" value="2">Carta3 </button>
    <button type="submit" name="boton" value="3">Carta4 </button>
    <button type="submit" name="boton" value="4">Carta5 </button>
    <button type="submit" name="boton" value="5">Carta6 </button>
</form>

<br>
<?php
   for($i = 0; $i<6;$i++ ){
    echo "<img src='img/{$_SESSION["negras"][$i]}'>";
   }
?>
<br><br>
<form action="ejercicio21.php" method="post">
<label for="resp">Número decimal</label>
<input type="number" name="resp" required>
<input type='submit' value='Enviar'>
</form>
</body>
</html>