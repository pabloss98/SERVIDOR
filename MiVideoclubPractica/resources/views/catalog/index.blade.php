<!-- resources/views/catalog/index.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Catálogo de Películas</h1>
    <ul>
        @foreach ($peliculas as $pelicula)
            <li>
                <a href="{{ route('catalog.show', $pelicula->id) }}">{{ $pelicula->title }}</a>
            </li>
        @endforeach
    </ul>
@endsection

