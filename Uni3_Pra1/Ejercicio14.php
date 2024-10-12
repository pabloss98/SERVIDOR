<?php

$ciudades=array(
    'MD' => 'Madrid',
    'BCN' => 'Barcelona',
    'LON' => 'Londres',
    'NY' => 'New York',
    'LA' => 'Los Ángeles',
    'CHI' =>'Chicago'
  );
  print_r($ciudades);
  echo "<br>";
  foreach ($ciudades as $clave => $valor) {
    echo "El índice del array que contiene como valor $valor es $clave<br>";
  }
?>