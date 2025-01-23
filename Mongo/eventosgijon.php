<?php
require 'C:/xampp/htdocs/vendor/autoload.php'; // Asegúrate de que Composer haya creado el autoload

function importarJSONAMongoDB($archivoJSON, $eventos, $nombreColeccion) {
    // Conectar a MongoDB
    $clienteMongo = new MongoDB\Client("mongodb://localhost:27017");
    $coleccion = $clienteMongo->$eventos->$nombreColeccion;

    // Leer el contenido del archivo JSON
    $contenido = file_get_contents('evento.json');
    
    // Decodificar el JSON
    $documentos = json_decode($contenido, true);

    // Verificar si la decodificación fue exitosa
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo "Error al decodificar el JSON: " . json_last_error_msg();
        return;
    }

    // Insertar documentos en MongoDB
    foreach ($documentos as $documento) {
        $coleccion->insertOne($documento);
    }

    echo "Datos importados exitosamente a MongoDB.";
}

// Llamar a la función
importarJSONAMongoDB('ruta/al/archivo.json', 'Eventosgijon', 'nombre_coleccion');
?>