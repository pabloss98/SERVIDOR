@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center">Catálogo de Pictogramas</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Categoría <span class="glyphicon glyphicon-book"></span></th>
                <th>Imagen <span class="glyphicon glyphicon-th"></span></th>
                <th>Ruta <span class="glyphicon glyphicon-list-alt"></span></th>
                <th>Descripción <span class="glyphicon glyphicon-plus-sign"></span></th>
            </tr>
        </thead>
        <tbody>
            @foreach($imagenes as $imagen)
            <tr>
                <td>{{ $imagen->categoria }}</td>
                <td><img src="{{ asset($imagen->imagen) }}" alt="{{ $imagen->descripcion }}" width="100"></td>
                <td>{{ asset($imagen->imagen) }}</td>
                <td>{{ $imagen->descripcion }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
