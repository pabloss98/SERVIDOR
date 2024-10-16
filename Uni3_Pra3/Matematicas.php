<?php
function resolverEcuacionSegundoGrado($a, $b, $c) {
   
   $discriminante = $b**2 - 4 * $a * $c;

   
   if ($discriminante < 0) {
       return false;
   }

   
   if ($discriminante == 0) {
       $solucion = -$b / (2 * $a);
       return [$solucion];
   }

   
   $solucion1 = (-$b + sqrt($discriminante)) / (2 * $a);
   $solucion2 = (-$b - sqrt($discriminante)) / (2 * $a);
   
   return [$solucion1, $solucion2];
}

?>