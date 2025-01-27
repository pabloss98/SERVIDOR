<?php
//migracion de mysql a mongodb
require 'C:/xampp/htdocs/vendor/autoload.php'; // Asegúrate de tener el autoload de Composer

// Conectar a MySQL
$mysqli = new mysqli("localhost", "root", "", "empresa");
if ($mysqli->connect_error) {
    die("Conexión fallida: " . $mysqli->connect_error);
}

// Consultar datos de MySQL
$resultado = $mysqli->query("SELECT * FROM empleados");

// Conectar a MongoDB
$clienteMongo = new MongoDB\Client("mongodb://localhost:27017");
$coleccion = $clienteMongo->nombre_base_datos->empleados;

// Insertar datos en MongoDB
while ($fila = $resultado->fetch_assoc()) {
    $coleccion->insertOne($fila);
}

// Cerrar conexión MySQL
$mysqli->close();
?>