<?php

echo "La matriz cargada es:<br>";
for ($i=0; $i<3; $i++) {
  for ($j=0; $j<4; $j++) {
    $matriz[$i][$j]=rand(0,100);
    echo $matriz[$i][$j]."   ";
  }
  echo '<br>';
}

$i=0;
  foreach ($matriz as $fila) {
    $x=max($fila);
    $maximos_fila[$i]=$x;
    $suma=0;
    for ($j=0; $j<count($fila); $j++) {
      $suma += $fila[$j];
    }
    $y=$suma/count($fila);
    $promedios_fila[$i]=$y;
    $i++;
    echo "Máximo Fila $i: $x<br>";
    echo "Promedio Fila $i: $y<br>";
  }

?>