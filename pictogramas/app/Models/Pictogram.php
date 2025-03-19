<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pictogram extends Model
{
use HasFactory;

    protected $table = 'pictogramas'; // nombre de tu tabla en la BD
    protected $fillable = ['name', 'image_path'];
}
