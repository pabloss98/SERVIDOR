<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie; // Importa el modelo Movie

class CatalogController extends Controller
{
    public function getIndex()
    {
        // Obtener todas las películas de la base de datos
        $peliculas = Movie::all();
        return view("catalog.index", compact('peliculas'));
    }

    public function getShow($id)
    {
       
        $pelicula = Movie::findOrFail($id);
        return view("catalog.show", compact('pelicula'));
    }

    public function getCreate()
    {
        // Aquí puedes implementar la lógica para mostrar el formulario de creación
        return view("catalog.create");
    }

	public function getEdit($id)
	{
		// Obtener la película para editar
		$pelicula = Movie::findOrFail($id);
		return view("catalog.edit", compact('pelicula'));
	}
    public function store(Request $request){
        // Validar los datos del formulario
        if(!empty($request->title) && !empty($request->year) && !empty($request->director) && !empty($request->poster) && !empty($request->synopsis)){
            // Crear una nueva película
            $pelicula = new Movie();
            $pelicula->title = $request->post('title');
            $pelicula->year = $request->post('year');
            $pelicula->director = $request->post('director');
            $pelicula->poster = $request->post('poster');
            $pelicula->synopsis = $request->post('synopsis');
            $pelicula->save();
            return redirect()->route('catalog.index');
    }
	
}



}