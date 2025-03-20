<x-layout>
    <x-containerTab>
       
        <li class="nav-item">
            <a class="nav-link text-white" href="{{url('/catalog')}}">Listado Pictogramas</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="{{url('agenda/add')}}">Nueva Entrada</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page"  href="{{url('agenda/buscar')}}">Mostrar Agenda</a>
        </li>
    </x-containerTab>
    <div class="container mt-5">
        <div class="row">
            <div class="row">
                <h1>Ver Agenda</h1>
            </div>
            <div class="row">
            <form method="POST" action="{{route('agenda.mostrar')}}">
                @csrf
                @php
                    $fecha=date("Y-m-d");
                @endphp
                <div class="mb-3">
                    <label for="fecha" class="form-label">Fecha</label>
                    <input type="date"class="form-control form-control-sm" name="fecha" id="fecha" value="{{$fecha}}"/>
                </div>
                <div class="mb-3">
                    <label for="id" class="form-label">Persona</label>
                    <select class="form-select form-select-lg" name="idpersona"id="idpersona">
                        @foreach($personas as $persona)
                            <option value="{{$persona->idpersona}}">{{$persona->nombre.' '.$persona->apellidos}}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Mostrar agenda</button>
            </form>
            </div>
        </div>
    </div>
</x-layout>