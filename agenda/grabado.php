<!DOCTYPE html>
<html>
	<head>
		<title>GRABADO</title>
		<meta charset = "UTF-8">
	</head>
	<body>
    <?php
session_start();
//Mostrar en pantalla un formulario donde seleccionar la fecha y persona de la base de datos y un boton para poder mostrar la agenda del dia de esa persona.
if (isset($_POST['grabar'])) {
    $cadena_conexion = 'mysql:dbname=agenda;host=127.0.0.1';
    $usuario = 'root';
    $clave = '';

    try {
        $bd = new PDO($cadena_conexion, $usuario, $clave);
        $bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Error de conexión a la base de datos: " . $e->getMessage());
    }

    if (isset($_SESSION['codusuario']) && $_SESSION['codusuario'] !== null) {
        for ($i = 1; $i <= $_SESSION['contador']; $i++) {
            $nombre = $_POST["nombre$i"] ?? '';
            $email = $_POST["email$i"] ?? '';
            $telefono = $_POST["telefono$i"] ?? '';

            if (!empty($nombre)) {
                $sql = "INSERT INTO contactos (nombre, email, telefono, codusuario) VALUES (:nombre, :email, :telefono, :codusuario)";
                $stmt = $bd->prepare($sql);
                $stmt->bindParam(':nombre', $nombre);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':telefono', $telefono);
                $stmt->bindParam(':codusuario', $_SESSION['codusuario']);
//Tengo que crear un formulario donde seleccionar la fecha del sistema, la hora pudiendo seleccionar franjas horarias y un desplegable con las personas que hay en la base de datos en la tabla personas debajo se ha de mostrar otra tabla como la realizada anteriormente pero con un boton de tipo radio para poder seleccionar una de ellas de cada vez. A partir de estos datos introducidos se ha de realizar una insercion en la base de datos en la tabla agenda.
                try {
                    $stmt->execute();
                    echo "Contacto $i guardado con éxito.<br>";
                } catch (PDOException $e) {
                    echo "Error al guardar el contacto $i: " . $e->getMessage() . "<br>";
                }
            } else {
                echo "Error al guardar el contacto $i: El nombre no puede estar vacío.<br>";
            }
        }
    } else {
        echo "Error al guardar los contactos: No se ha establecido correctamente la sesión de usuario.<br>";
    }

    $bd = null;
}
?>
		<h2>AGENDA</h2>
	
		<h3>Hola <?php echo $_SESSION['nombre'];?></h3>
		
		<p>Se han grabado los <?php echo $_SESSION['contador'];?> contactos de <?php echo $_SESSION['nombre'];?></p>
		<a href="index.php">Volver a loguearse</a>
		<br/>
		<a href="inicio.php">Introducir más contactos para <?php echo $_SESSION['nombre'];?> </a>
		<br/>
		<a href="totales.php">Total de contactos guardados</a>
	</body>
</html>