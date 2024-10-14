<?php

echo "<html>\n<body>\n";
$numeros=array(3,2,8,123,5,1);
echo "Array original: ";
print_r($numeros);
sort($numeros);

echo "<br>"; 
echo "Array ordenado de menor a mayor: <br>"; 
echo "<table border='3' cellpadding='10'>\n<tr><th>Número</th></tr>\n";
foreach ($numeros as $valor) {
  echo "<tr><td>$valor</td></tr>\n";
}
echo "</table>\n</body>\n</html>";


?>