<?php
// Parámetros de conexión a MySQL
$servername = "localhost";  // Nombre del servidor
$username = "root";         // Usuario de MySQL
$password = "";             // Contraseña de MySQL (si es necesario)
$dbname = "mi_base_de_datos";  // Nombre de la base de datos que vamos a crear

// Crear la conexión
$conn = new mysqli($servername, $username, $password);

// Comprobar si la conexión fue exitosa
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Crear la base de datos (si no existe)
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    echo "Base de datos '$dbname' creada o ya existe.\n";
} else {
    echo "Error al crear la base de datos: " . $conn->error;
}

// Seleccionar la base de datos
$conn->select_db($dbname);

// Crear la tabla (si no existe)
$sql = "CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    edad INT NOT NULL
)";
if ($conn->query($sql) === TRUE) {
    echo "Tabla 'usuarios' creada o ya existe.\n";
} else {
    echo "Error al crear la tabla: " . $conn->error;
}

// Insertar un registro en la tabla
$sql = "INSERT INTO usuarios (nombre, edad) VALUES ('Juan Perez', 30)";
if ($conn->query($sql) === TRUE) {
    echo "Nuevo registro insertado correctamente.\n";
} else {
    echo "Error al insertar el registro: " . $conn->error;
}

// Consultar los registros
$sql = "SELECT * FROM usuarios";
$result = $conn->query($sql);

// Mostrar los registros
if ($result->num_rows > 0) {
    // Mostrar cada fila de los resultados
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"]. " - Nombre: " . $row["nombre"]. " - Edad: " . $row["edad"]. "\n";
    }
} else {
    echo "0 resultados.\n";
}

// Cerrar la conexión
$conn->close();
?>
