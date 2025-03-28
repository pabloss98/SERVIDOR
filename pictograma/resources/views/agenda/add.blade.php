<x-layout>
    <x-containerTab>
        <li class="nav-item">
            <a class="nav-link text-white" href="{{url('/catalog')}}">Listado Pictogramas</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="{{url('agenda/add')}}">Nueva Entrada</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="{{url('agenda/buscar')}}">Mostrar Agenda</a>
        </li>
    </x-containerTab>
    
    <div class="container mt-5">
        <div class="row">
            <h1>Añadir Datos Agenda</h1>
        </div>
        <div class="row">
            @if(session('info'))
            <div class="alert alert-success" role="alert">
                {{session('info')}}
            </div>
            @endif
            <form method="POST" action="{{url('agenda/add')}}">
                @csrf
                @php
                    $fecha=date("Y-m-d");
                    $hora=date("H:i:s");
                @endphp
                
                <div class="row">
                    <div class="mb-3 col-md-4">
                        <label for="fecha" class="form-label">Fecha</label>
                        <input type="date" class="form-control form-control-sm" name="fecha" id="fecha" value="{{$fecha}}"/>
                    </div>
                    <div class="mb-3 col-md-4">
                        <label for="hora" class="form-label">Hora</label>
                        <input type="time" class="form-control form-control-sm" name="hora" id="hora" value="{{$hora}}"/>
                    </div>
                    <div class="mb-3 col-md-4">
                        <label for="idpersona" class="form-label">Persona</label>
                        <select class="form-select form-select-lg" name="idpersona" id="idpersona">
                            @foreach($personas as $persona)
                                <option value="{{$persona->idpersona}}">{{$persona->nombre.' '.$persona->apellidos}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    @foreach ($imagenes as $img)
                        <div class="card col-3 text-center">
                            <label class="form-check-label" for="{{$img->idimagen}}">{{$img->imagen}}</label>
                            <input class="form-check-input" type="radio" name="idimagen" value="{{$img->idimagen}}" id="img{{$img->idimagen}}">
                            <img class="card-img-top imgs mx-auto" src="{{asset($img->imagen)}}" alt="{{$img->descripcion}}">
                            <h2 class="card-text">{{$img->descripcion}}</h2>
                        </div>     
                    @endforeach
                </div>
                <button type="submit" class="btn btn-primary">Agregar</button>
            </form>
        </div>
    </div>
</x-layout>
