<?php
$hashedPassword = '$2y$10$25EQbSVljHO2KzS8VF'; // Reemplaza esto con el hash que tienes en la base de datos
$password = '1234'; // La contraseña que estás probando

if (password_verify($password, $hashedPassword)) {
    echo "La contraseña es correcta.";
} else {
    echo "La contraseña es incorrecta.";
}
?>