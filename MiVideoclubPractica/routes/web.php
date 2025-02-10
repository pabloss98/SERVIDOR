<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    //return view('welcome');
    echo "Pagina Principal";
});

Route::get('login', function () {
    echo "Login usuario";
});

Route::get('logout', function () {
    echo "Logout usuario";
});

Route::get('catalog', function () {
    echo "Listado peliculas";
});

Route::get('catalog/show/{id}', function ($id) {
    echo "Vista detalle pelicula ".$id;
});

Route::get('catalog/create', function () {
    echo "Añadir pelicula";
});

Route::get('catalog/edit/{id}', function ($id) {
    echo "Modificar pelicula ".$id;
});