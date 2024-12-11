<!DOCTYPE html>
<html>
	<head>
		<title>Inicio</title>
		<meta charset = "UTF-8">
	</head>
	<body>
    <?php
			session_start();

			if (isset($_GET['reset']) && $_GET['reset'] == '1') {
				session_unset();
				session_destroy();
				header("Location: index.php");
				exit();
			}
		?>

		<h2>AGENDA</h2>
		<h3>Hola <?php echo $_SESSION['nombre'];?>, cuantos contactos deseas grabar?</h3>
        <h3>Puedes grabar entre 1 y 5. Por cada pulsación en INCREMENTAR grabarás un usuario más.</h3>
        <h3>Cuando el número sea el deseado pulsa GRABAR.</h3>

		<form method="post">
			<input style="float:left;"  type="submit" value="INCREMENTAR" name="imagen">
		</form>

		<form action="agenda.php" method="POST" enctype="multipart/form-data">
			<input type="submit" value="GRABAR" name="grabar">
		</form>	
	<?php
		if(!isset($_SESSION['contador'])){
			$_SESSION['contador'] = 0;
		}
		if(isset($_POST['imagen'])){
			$imagenes = array("OIP0.jfif", "OIP1.jfif", "OIP2.jfif", "OIP3.jfif", "OIP4.jfif");
			$imagen_aleatoria = $imagenes[array_rand($imagenes)];

			
			$_SESSION['imagenes'][] = $imagen_aleatoria;
			$_SESSION['contador']++;
			
			
			if($_SESSION['contador'] >= 5){
				header("Location: agenda.php");
			}
		}
		if(isset($_SESSION['imagenes'])){
			echo "<table>";
			echo "<tr>";
			foreach($_SESSION['imagenes'] as $imagen){
				echo "<td><img width='200' height='150' style='border: 5px black;border-color: black;border-style: double;margin-bottom: 10px;' src='$imagen' alt='Imagen aleatoria'></td>";
			}
			echo "</tr>";
			echo "</table>";
		}
	?>
    		<a href="inicio.php?reset=1">Reiniciar la aplicación</a>
	</body>
</html>