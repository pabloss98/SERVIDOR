<?php

  $deportes=['fútbol','baloncesto','natación','tenis'];
  foreach ($deportes as $valor) {
    echo "$valor<br>";
  }
  echo "El array tiene " . count($deportes) . " valores<br>";
  $mode=current($deportes);
  echo "Primer valor del array es '$mode'<br>";
  $mode=next($deportes);
  echo "El siguiente valor del array es '$mode'<br>";
  $mode=end($deportes);
  echo "El último valor del array es '$mode'<br>";
  $mode=prev($deportes);
  echo "El penúltimo valor del array es '$mode'<br>";
?>
