<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
   // return view('welcome');
   echo "Hola mundo";
});

Route::get('pagina1', function () {
    return'Estás en la pagina 1';
 });

 Route::get('usuario/{id}', function ($id) {
    echo 'Usuario' .$id;
 });

 Route::get('user/{name?}', function($name = null)
{
return $name;
});
// También podemos poner algún valor por defecto...
Route::get('user/{name?}', function($name = 'Pablo')
{
return $name;
});