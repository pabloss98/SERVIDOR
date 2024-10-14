<?php

$x=array(
    5=>1,
    12=>2,
    13=>56,
    "x"=>42
  );
  echo "Array original:<br>";
  print_r($x);
  echo "<br>";
  echo "El array tiene " . count($x) . " elementos";

  array_shift($x);
  echo "<br>";
  echo "Array tras borrar el primer elemento:<br>";
  print_r($x);
  unset($x);
  if (isset($x)) {
    echo "<br>El array no se ha borrado";
  } else {
    echo "<br>El array se ha eliminado";
  }

?>