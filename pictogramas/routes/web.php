<?php

use App\Http\Controllers\PictogramController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\ImagenController;

Route::get('/pictogramas', [PictogramController::class, 'index'])->name('pictogramas.index');



Route::get('/agenda/create', [AgendaController::class, 'create'])->name('agenda.create');
Route::post('/agenda', [AgendaController::class, 'store'])->name('agenda.store');
Route::get('/catalogo', [ImagenController::class, 'index']);

