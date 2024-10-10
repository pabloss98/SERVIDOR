<?php

class Persona{


public $nombre;
public $apellido;
public $edad;

public function saludar(){
    return 'Hola, soy ' . $this->nombre . ' ' . $this->apellido . ' y
    tengo ' . $this->edad . ' años ';
    }
}

?>
