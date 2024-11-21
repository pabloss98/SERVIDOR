<?php
function validar_email($email) {
    // Expresión regular para validar correos electrónicos
    $pattern = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";

    // Usar preg_match para comprobar el formato del email
    if (preg_match($pattern, $email)) {
        return true; // El email es válido
    } else {
        return false; // El email no es válido
    }
}

// Ejemplo de uso
$email = "usuario@ejemplo.com";
if (validar_email($email)) {
    echo "El correo electrónico es válido.";
} else {
    echo "El correo electrónico no es válido.";
}
?>
