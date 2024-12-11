<!DOCTYPE html>
<html>
	<head>
		<title>Agenda</title>
		<meta charset = "UTF-8">
	</head>
	<body>
	<?php
	if(isset($_POST['usuario'])){

		$cadena_conexion = 'mysql:dbname=agenda;host=127.0.0.1';
		$usuario = 'root';
		$clave = '';
		
        $bd = new PDO($cadena_conexion, $usuario, $clave);		

		$nom = 	$_POST['usuario'];
		$pass =	$_POST['pass'];
		$select = "SELECT codigo, nombre, clave FROM usuarios WHERE nombre='$nom' AND clave='$pass'";
		$usuario = $bd->query($select);
		$datos= $usuario->fetch(PDO::FETCH_ASSOC);
	}
	?>
		<h2>AGENDA DE CONTACTOS</h2>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" enctype="multipart/form-data">
		Usuario:
		<input type="text" name="usuario">
		Clave:
		<input type="password" name="pass">
		<input type="submit" value="Entrar" name="entrar">
		</form>
		<?php
			if(isset($_POST['usuario'])){
			if(empty($datos)){echo "<br/>El usuario introducido no existe, validese de nuevo.</div>";}
				else{ 			
					session_start();
					$_SESSION['nombre']=$nom;
					$_SESSION['codusuario']=$datos['codigo'];
					header('Location: inicio.php');
				}
			}
		?>		
		
	</body>
</html>