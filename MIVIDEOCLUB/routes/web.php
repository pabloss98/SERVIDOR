<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
   // return view('welcome');
   echo "Hola mundo";
});

Route::get('pagina1', function () {
    return'Estás en la pagina 1';
 });

 Route::get('pagina2', function () {
    return'Estás en la pagina 2';
 });