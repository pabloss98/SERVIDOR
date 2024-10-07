<?php

echo "La matriz cargada es:<br>";
for ($i=0; $i<3; $i++) {
  for ($j=0; $j<5; $j++) {
    $matriz[$i][$j]=rand(0,9);
    echo $matriz[$i][$j]."   ";
  }
  echo '<br>';
}
echo "Todos los numeros por fila son los siguienetes: ";

foreach ($matriz as $fila){
    
    
    foreach($fila as $valor){
        echo $valor;

    }
}

echo "<br>";
echo "Todos los numeros por columna son los siguienetes: ";
for ($j=0; $j<5; $j++) {
  for ($i=0; $i<3; $i++) {
    echo $matriz[$i][$j];
  }
}


?>