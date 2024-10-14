<?php

$estadios_futbol=array("Barcelona"=>"Camp Nou", "Real Madrid"=>"Santiago Bernabéu", "Valencia" => "Mestalla", "Real Sociedad" => "Anoeta");


  echo "<html>\n<body>\n";
  echo "<table border='1' cellpadding='5'>\n<tr><th>Ciudad</th><th>Estadio</th></tr>\n";
  foreach ($estadios_futbol as $ciudad => $estadio) {
    echo "<tr><td>$ciudad</td><td>$estadio</td></tr>\n";
  }
  echo "</table>\n";
  unset($estadios_futbol["Real Madrid"]);
  echo "<ol>\n";
  foreach ($estadios_futbol as $ciudad => $estadio) {
    echo "<li>$ciudad: $estadio</li>\n";
  }
  echo "</ol>\n</body>\n</html>";
?>