<!DOCTYPE html>
<html>
<head>
    <title>Agenda</title>
    <meta charset="UTF-8">
</head>
<body>
    <?php
    session_start();

    if (isset($_POST['grabar'])) {
        if (isset($_SESSION['codusuario']) && $_SESSION['codusuario'] !== null) {
            $cadena_conexion = 'mysql:dbname=agenda;host=127.0.0.1';
            $usuario = 'root';
            $clave = '';

            try {
                $bd = new PDO($cadena_conexion, $usuario, $clave);
                $bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Error de conexión a la base de datos: " . $e->getMessage());
            }

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

            $bd = null;
        } else {
            echo "Error al guardar los contactos: No se ha establecido correctamente la sesión de usuario.<br>";
        }
    }
    ?>
    <h2>AGENDA</h2>
    <h3>Hola <?php echo $_SESSION['nombre']; ?></h3>
    <?php
    if (isset($_SESSION['imagenes'])) {
        echo "<form style='border: 5px black;border-color: black;border-style: double;padding: 5px;' method='post' action='grabado.php'>";
        for ($i = 1; $i <= $_SESSION['contador']; $i++) {
            echo "<h2>Contacto $i</h2>";
            echo "<input type='hidden' name='imagen$i' value=''>";
            echo "<label for='nombre$i'>Nombre $i :</label>";
            echo "<input type='text' id='nombre$i' name='nombre$i'><br>";
            echo "<label for='email$i'>Email $i:</label>";
            echo "<input type='email' id='email$i' name='email$i'><br>";
            echo "<label for='telefono$i'>Telefono $i:</label>";
            echo "<input type='text' id='telefono$i' name='telefono$i'><br>";
        }
        echo "<input type='submit' value='GRABAR' name='grabar'>";
        echo "</form>";
    }
    ?>
</body>
</html>







