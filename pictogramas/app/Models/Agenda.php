<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha',
        'hora',
        'persona_id',
        'pictogram_id'
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }

    public function pictogram()
    {
        return $this->belongsTo(Pictogram::class);
    }
}
