<?php

namespace Database\Seeders;

use App\Models\Pictogram;
use Illuminate\Database\Seeder;

class PictogramSeeder extends Seeder
{
    public function run()
    {
        Pictogram::create([
            'name' => 'Pictograma 1',
            'image_path' => 'images/pictogram1.jpg'
        ]);
        // Añade más pictogramas según necesites
    }
}
