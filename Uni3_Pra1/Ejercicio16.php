<?php

$lenguajes_cliente = array(

    "J" => "JavaScript",
    "H" => "HTML",
    "C" => "CSS"
);

$lenguajes_servidor = array(

    "P" => "PHP",
    "PY" => "Python",
    "N" => "Node.js"
);

$lenguajes = array_merge($lenguajes_cliente, $lenguajes_servidor);

echo "<table>";
foreach ($lenguajes as $clave => $valor) {

    echo "<tr>";
    echo "<th>" . $clave . "</th>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>" . $valor . "</td>";
    echo "</tr>";

  }


echo "</table>";
?>