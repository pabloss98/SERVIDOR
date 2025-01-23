<?php

require 'vendor/autoload.php'; 

use MongoDB\Client;

class MongoDBConnection {
    private $client;
    private $database;

    public function __construct($uri = "mongodb://localhost:27017", $dbName = "mi_base_de_datos") {
        try {
            $this->client = new Client($uri);
            $this->database = $this->client->$dbName;
            echo "Conexión exitosa a MongoDB" . PHP_EOL;
        } catch (Exception $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

    public function getDatabase() {
        return $this->database;
    }

    public function createCollection($collectionName) {
        try {
            $collection = $this->database->$collectionName;
            echo "Colección '$collectionName' creada o seleccionada correctamente." . PHP_EOL;
            return $collection;
        } catch (Exception $e) {
            die("Error al crear la colección: " . $e->getMessage());
        }
    }

    public function insertDocument($collectionName, $document) {
        try {
            $collection = $this->database->$collectionName;
            $insertOneResult = $collection->insertOne($document);
            echo "Documento insertado con ID: " . $insertOneResult->getInsertedId() . PHP_EOL;
        } catch (Exception $e) {
            die("Error al insertar documento: " . $e->getMessage());
        }
    }
}

// Uso del módulo
$mongoDB = new MongoDBConnection();
$db = $mongoDB->getDatabase();

// Crear una colección y agregar un documento
$collectionName = "usuarios";
$mongoDB->createCollection($collectionName);
$mongoDB->insertDocument($collectionName, ["nombre" => "Juan Pérez", "email" => "juan@example.com"]);

?>
