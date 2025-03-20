<x-layout>
    <x-containerTab>
        <li class="nav-item">
            <a class="nav-link text-white" href="{{url('/catalog')}}">Listado Pictogramas</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="{{url('agenda/add')}}">Nueva Entrada</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="{{url('agenda/buscar')}}">Mostrar Agenda</a>
        </li>
    </x-containerTab>

    <div class="row">
        <div class="row">
            @if ($agenda->isNotEmpty())  
                <h1>Agenda del Día para {{ $agenda[0]->nombre . ' ' . $agenda[0]->apellidos }}</h1>
                <h2>Fecha: {{ $agenda[0]->fecha }}</h2>
            @else
                <h1>No hay registros para la fecha seleccionada.</h1>
            @endif
        </div>

        @foreach ($agenda as $ag)
        <div class="card col-3 text-center">
            <img class="card-img-top imgs mx-auto" src="{{ asset($ag->imagen) }}" alt="{{ $ag->descripcion }}">
            <div class="card-body">
                <h5 class="card-title">{{ $ag->imagen }}</h5>
                <h5>{{ $ag->hora }}</h5>
            </div>
        </div>
        @endforeach
    </div>
</x-layout>
