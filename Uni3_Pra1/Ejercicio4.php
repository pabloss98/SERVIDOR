<?php

$n=4;
  echo "La matriz cargada es:<br>";
  for ($i=0; $i<$n; $i++) {
    for ($j=0; $j<$n; $j++) {
      $matriz[$i][$j]=rand(0,9);
	  echo $matriz[$i][$j]."   ";
    }
	echo '<br>';
  }

  echo "<br>";
  echo "Los numeros de la diagonal son: ";

  for ($i = 0; $i <4; $i++){
    echo $matriz[$i][$i] . " ";
  }

  echo "<br>";
  echo "Los numeros de la diagonal inversa son: ";


  for ($i = 0; $i <4; $i++){
    echo $matriz[$i][3-$i] . " ";
  }

?>