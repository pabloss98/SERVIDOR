<?php

  $gente = array (
    array(
      'Familia' => 'Los Simpson',
      'Padre' => 'Homer',
      'Madre' => 'Marge',
      'Hijos' => array('Bart', 'Lisa' , 'Maggie')
    ),
    array(
      'Familia' => 'Los Griffin',
      'Padre' => 'Peter',
      'Madre' => 'Lois',
      'Hijos' => array('Chris', 'Meg' , 'Stewie')
    )
  );
  echo "<html>\n<body>\n<ul>\n";

  foreach ($gente as $familia) {
    foreach ($familia as $clave => $valor) {
      if ($clave=='Familia') {
        echo "<li>$valor</li>\n<ul>\n";
      } else if ($clave=='Hijos') {
        echo "<li>$clave</li><ul>\n";
        foreach ($valor as $hijos) {
          echo "<li>$hijos</li>\n";
        }
        echo "</ul>\n";
      } else {
        echo "<li>$clave: $valor</li>\n";
      }
    }
    echo "</ul>\n";
  }
  echo "</ul>\n</body>\n</html>";
?>