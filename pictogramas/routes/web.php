<?php

use App\Http\Controllers\PictogramController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgendaController;

Route::get('/pictogramas', [PictogramController::class, 'index'])->name('pictogramas.index');



Route::get('/agenda/create', [AgendaController::class, 'create'])->name('agenda.create');
Route::post('/agenda', [AgendaController::class, 'store'])->name('agenda.store');

