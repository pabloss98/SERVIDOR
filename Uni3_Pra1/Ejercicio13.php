<?php

$ciudades=['Madrid','Barcelona','Londres','New York','Los Ángeles','Chicago'];
  print_r($ciudades);
  echo "<br>";
  for ($i=0; $i<count($ciudades); $i++) {
    echo "La ciudad con el índice $i tiene el nombre de $ciudades[$i]<br>";
  }

?>