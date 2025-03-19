<?php

namespace App\Http\Controllers;

use App\Models\Imagen;
use Illuminate\Http\Request;

class ImagenController extends Controller
{
    public function index()
    {

        $imagenes = Imagen::all();
        return view('imagenes.index', compact('imagenes'));
    }
}