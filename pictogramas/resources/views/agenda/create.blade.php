<!DOCTYPE html>
<html>
<head>
    <title>Crear Nueva Agenda</title>
    <style>
        .form-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .pictogram-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin: 20px 0;
        }
        .pictogram-item {
            text-align: center;
        }
        .pictogram-item img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Nueva Entrada en la Agenda</h1>

        <form method="POST" action="{{ route('agenda.store') }}">
            @csrf
            
            <div>
                <label for="fecha">Fecha:</label>
                <input type="date" id="fecha" name="fecha" required>
            </div>

            <div>
                <label for="hora">Hora:</label>
                <input type="time" id="hora" name="hora" required>
            </div>

            <div>
                <label for="persona_id">Persona:</label>
                <select name="persona_id" id="persona_id" required>
                    <option value="">Seleccione una persona</option>
                    @foreach($personas as $persona)
                        <option value="{{ $persona->id }}">{{ $persona->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <h3>Seleccione un pictograma:</h3>
                <div class="pictogram-grid">
                    @foreach($pictograms as $pictogram)
                        <div class="pictogram-item">
                            <input type="radio" 
                                   id="pictogram_{{ $pictogram->id }}" 
                                   name="pictogram_id" 
                                   value="{{ $pictogram->id }}" 
                                   required>
                            <label for="pictogram_{{ $pictogram->id }}">
                                <img src="{{ asset($pictogram->image_path) }}" 
                                     alt="{{ $pictogram->name }}">
                                <p>{{ $pictogram->name }}</p>
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <button type="submit">Guardar</button>
        </form>
    </div>
</body>
</html>
