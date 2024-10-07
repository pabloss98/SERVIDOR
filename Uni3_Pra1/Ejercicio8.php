<?php

echo "La matriz cargada es:<br>";
for($i=0; $i<10; $i++){
    for($j=0; $j<10; $j++){
        $matriz[$i][$j] = rand(0, 100);
        echo $matriz[$i][$j]  . "  ";
    }
    echo"<br>";
}

$mayor = $matriz[0][0];

$fila=1; $col=1;
  for ($i=0; $i<4; $i++) {
    for ($j=0; $j<5; $j++) {
      if ($matriz[$i][$j]>$mayor) {
        $mayor=$matriz[$i][$j];
        $fila=$i+1;
        $col=$j+1;
      }
    }
  }

  echo "El elemento más grande es el: $mayor y está en la fila $fila y en la columna $col ";



?>