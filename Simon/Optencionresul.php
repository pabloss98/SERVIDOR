<?php // query-mysqli.php
    require_once 'login.php';
    $connection = new mysqli($hn, $un, $pw, $db);
        if ($connection->connect_error) die("Fatal Error");
            $query = "SELECT usu, contraseña FROM usuarios";
            $insertar="INSERT INTO usuarios(usu, contraseña, rol) VALUES ('yolanda', 'yolanda', 'Jugador')";
            $connection->query($insertar);
            $eliminar= ("DELETE FROM usuarios WHERE usu = 'yolanda'");
            $result = $connection->query($eliminar);
            $result = $connection->query($query);
        if (!$result) die("Fatal Error");
            $rows = $result->num_rows;

        for ($j = 0 ; $j < $rows ; ++$j){


            $result->data_seek($j);
            echo 'Usuario: ' .htmlspecialchars($result->fetch_assoc()['usu']) .'<br>';

        }

 $result->close();
 $connection->close();
?> 