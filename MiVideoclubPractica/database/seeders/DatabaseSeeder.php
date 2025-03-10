<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Movie; // Importamos el modelo Movie

class DatabaseSeeder extends Seeder
{
    // Array de películas (ajusta los valores según los datos proporcionados)
    private $arrayPeliculas = [
        [
            'title' => 'The Shawshank Redemption',
            'year' => 1994,
            'director' => 'Frank Darabont',
            'poster' => 'https://example.com/shawshank.jpg',
            'rented' => false,
            'synopsis' => 'Dos hombres encarcelados forjan una profunda amistad...'
        ],
        [
            'title' => 'The Godfather',
            'year' => 1972,
            'director' => 'Francis Ford Coppola',
            'poster' => 'https://example.com/godfather.jpg',
            'rented' => false,
            'synopsis' => 'La historia de la familia criminal Corleone...'
        ],
        // Puedes agregar más películas aquí...
    ];

    public function run()
    {
        self::seedCatalog();
        $this->command->info('Tabla catálogo inicializada con datos!');
    }

    private function seedCatalog()
    {
        // Eliminar todos los registros de la tabla 'movies'
        DB::table('movies')->delete();

        // Recorrer el array e insertar los datos en la base de datos
        foreach ($this->arrayPeliculas as $pelicula) {
            $p = new Movie;
            $p->title = $pelicula['title'];
            $p->year = $pelicula['year'];
            $p->director = $pelicula['director'];
            $p->poster = $pelicula['poster'];
            $p->rented = $pelicula['rented'];
            $p->synopsis = $pelicula['synopsis'];
            $p->save();
        }
    }
}
