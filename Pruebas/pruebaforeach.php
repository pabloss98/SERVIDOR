<?php
     $mascotas = array( 'Perro' => array('Mastin' =>'Yunito', 'Salchicha' => 'Fuet', 'Chiguagua' => 'Sarnoso'),
                        'Gato' => array('Persa' => 'Otis', 'Comun' => 'Garfield', 'Siames' => 'Princesa') );
        
        
    foreach($mascotas as $tipo => $descripcion){
         echo "Tipo mascota: $tipo</br>";

         foreach($descripcion as $raza => $nombre){
            echo "La raza es $raza, el nombre es $nombre</br>";
         }
    }

?> 