<?php

  $amigos=array(
    'Madrid' => array('Nombre' => 'Pedro', 'Edad' => '32', 'Teléfono' => '91-999.99.99'),
    'Barcelona' => array('Nombre' => 'Susana', 'Edad' => '34', 'Teléfono' => '93-000.00.00'),
    'Toledo' => array('Nombre' => 'Sonia', 'Edad' => '42', 'Teléfono' => '925-09.09.09'),
  );
  foreach ($amigos as $ciudad => $datos) {
    echo "Ciudad: <b>$ciudad</b><br>";
    foreach ($datos as $clave => $valor) {
      echo "$clave: $valor<br>";
    }
  }
?>
