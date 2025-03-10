<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie; // Importamos el modelo Movie

class CatalogController extends Controller
{
    // Mostrar todas las películas
    public function getIndex()
    {
        $movies = Movie::all(); // Obtener todas las películas de la base de datos
        return view('catalog.index', compact('movies')); // Pasarlas a la vista
    }

    // Mostrar detalles de una película específica
    public function getShow($id)
    {
        $pelicula = Movie::findOrFail($id); // Buscar la película o lanzar un error 404
        return view('catalog.show', compact('pelicula'));
    }

    // Editar película
    public function getEdit($id)
    {
        $pelicula = Movie::findOrFail($id); // Buscar la película o lanzar un error 404
        return view('catalog.edit', compact('pelicula'));
    }
}
