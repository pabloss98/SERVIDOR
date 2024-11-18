<?php
/* Escribe un script para probar algunas de las funciones mostradas debajo, el sript
ha de contener al menos tres funciones de cada bloque */
// Bloque "Funciones de variables"
  $var1='3';
  $var2=NULL;
  $var3=4.5;
  $var4=5;
  for ($i=1; $i<=4; $i++) {
    echo "var $i<br>";
    $tmp=${'var'.$i};
    var_dump(isset($tmp));
    var_dump(is_null($tmp));
    var_dump(is_int($tmp));
    var_dump(is_float($tmp));
    echo "<br>";
  }

  echo "<br><br>";

// Bloque "Funciones de cadenas"
  $cadena1="Esto es una prueba";
  $cadena2="una prueba";
  echo "La longitud de la cadena '${cadena1}' es " . strlen($cadena1) . "<br>";
  $cadena1e=explode(" ",$cadena1);
  echo "Después de explode:<br>";
  print_r($cadena1e);
  echo "<br>";
  echo "'$cadena1' en mayúsculas es " . strtoupper($cadena1) . "<br>";
  echo "Función str_contains (PHP 8):<br>";
  if (str_contains($cadena1,$cadena2)) {
    echo "'$cadena2' está contenida en '$cadena1'";
  }

  echo "<br><br>";

// Bloque "Funciones de array"
  $x=array(
    'nombre' => 'Yolanda',
    'Apellido 1' => 'Iglesias',
    'Apellido 2' => 'Suarez',
    'tfno' => '12345678',
    'Sexo' => 'Mujer',
  );

  echo "Array original:<br>";
  print_r($x);
  echo "<br>";
  ksort($x);
  echo "Array con claves ordenadas:<br>";
  print_r($x);
  echo "<br>";
  echo "Claves del array:<br>";
  print_r(array_keys($x));
  echo "<br>";
  echo "Valores del array:<br>";
  print_r(array_values($x));
  $clave='Apellido 3';
  echo "<br>";
  if (array_key_exists($clave,$x)) {
    echo "La clave '$clave' está en el array";
  } else {
    echo "La clave '$clave' NO está en el array";
  }


?>
