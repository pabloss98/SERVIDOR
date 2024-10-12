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

  for ($i=0; $i<count($ciudades); $i++) {
    echo "La ciudad con el índice $i tiene el nombre de $ciudades[$i]<br>";
  }


?>