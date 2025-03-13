<!-- resources/views/catalog/show.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>{{ $pelicula->title }}</h1>
    <p>Año: {{ $pelicula->year }}</p>
    <p>Director: {{ $pelicula->director }}</p>
    <p>Sinopsis: {{ $pelicula->synopsis }}</p>
    <img src="{{ $pelicula->poster }}" alt="{{ $pelicula->title }}">
    <a href="{{ route('catalog.edit', $pelicula->id) }}">Editar</a>
@endsection
