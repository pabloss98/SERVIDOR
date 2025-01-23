<?php
require 'C:/xampp/htdocs/vendor/vendor/autoload.php'; // Asegúrate de que Composer haya creado el autoload

// Conectar a MongoDB
$clienteMongo = new MongoDB\Client("mongodb://localhost:27017");
$coleccionMongo = $clienteMongo->Eventosgijon->nombre_coleccion;

// Conectar a MySQL
$mysqli = new mysqli("localhost", "root", "", "Eventosgijon");
if ($mysqli->connect_error) {
    die("Conexión fallida a MySQL: " . $mysqli->connect_error);
}

// Extraer datos de MongoDB
$cursor = $coleccionMongo->find();

foreach ($cursor as $documento) {
    // Preparar la consulta de inserción en MySQL
    $nombre = $mysqli->real_escape_string($documento['nombre']);
    $apellido1 = $mysqli->real_escape_string($documento['apellido1']);
    $apellido2 = $mysqli->real_escape_string($documento['apellido2']);
    $numero_departamento = (int)$documento['numero_departamento'];

    $sql = "INSERT INTO empleados (nombre, apellido1, apellido2, numero_departamento) VALUES ('$nombre', '$apellido1', '$apellido2', $numero_departamento)";

    // Ejecutar la consulta
    if (!$mysqli->query($sql)) {
        echo "Error al insertar en MySQL: " . $mysqli->error . "\n";
    }
}

// Cerrar conexiones
$mysqli->close();

echo "Migración completada exitosamente.";
?>