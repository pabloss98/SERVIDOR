<?php

use App\Http\Controllers\CatalogController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;



Route::get('/catalog', [CatalogController::class, 'getIndex'])->name('catalog.index');

Route::post('/catalog', [CatalogController::class, 'store'])->name('catalog.store'); // Ruta para almacenar una nueva película
Route::get('/catalog/show/{id}', [CatalogController::class, 'getShow'])->name('catalog.show');
Route::get('/catalog/{id}/edit', [CatalogController::class, 'getEdit'])->name('catalog.edit');
Route::get('/catalog/create', [CatalogController::class, 'getCreate'])->name('catalog.create');

