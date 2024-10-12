<?php
  $gente=['Pedro','Ismael','Sonia','Clara','Susana','Alfonso','Teresa'];
  echo "<html>\n<body>\n<ul>\n";
  for ($i=0; $i<count($gente); $i++) {
    echo "<li>$gente[$i]</li>\n";
  }
  echo "</ul>\n</body>\n</html>";
?>