<?php

namespace App\Http\Controllers;

use App\Models\Imagen;
use Illuminate\Http\Request;

class PictogramController extends Controller
{
    public function index()
    {
        $pictograms = Imagen::all();
        return view('pictograms.index', compact('pictograms'));
    }
}
