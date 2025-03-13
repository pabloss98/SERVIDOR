<!-- resources/views/catalog/edit.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Editar Película: {{ $pelicula->title }}</h1>
    <form action="{{ route('catalog.update', $pelicula->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="title">Título:</label>
        <input type="text" name="title" value="{{ $pelicula->title }}" required>

        <label for="year">Año:</label>
        <input type="text" name="year" value="{{ $pelicula->year }}" required>

        <label for="director">Director:</label>
        <input type="text" name="director" value="{{ $pelicula->director }}" required>

        <label for="poster">Poster:</label>
        <input type="text" name="poster" value="{{ $pelicula->poster }}" required>

        <label for="synopsis">Sinopsis:</label>
        <textarea name="synopsis" required>{{ $pelicula->synopsis }}</textarea>

        <button type="submit">Actualizar</button>
    </form>
@endsection

