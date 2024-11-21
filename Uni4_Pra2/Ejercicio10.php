<?php
function validar_url($url) {
    // Usar filter_var con el filtro FILTER_VALIDATE_URL para validar la URL
    if (filter_var($url, FILTER_VALIDATE_URL)) {
        return true; // La URL es válida
    } else {
        return false; // La URL no es válida
    }
}

// Ejemplo de uso
$url = "https://www.ejemplo.com";
if (validar_url($url)) {
    echo "La URL es válida.";
} else {
    echo "La URL no es válida.";
}
?>
