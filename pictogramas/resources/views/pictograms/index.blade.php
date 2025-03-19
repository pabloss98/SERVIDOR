<!DOCTYPE html>
<html>
<head>
    <title>Catálogo de Pictogramas</title>
    <style>
        .pictogram-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            padding: 20px;
        }
        .pictogram-item {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        .pictogram-item img {
            max-width: 100%;
            height: auto;
        }
        .pictogram-path {
            margin-top: 10px;
            word-break: break-all;
            font-size: 0.9em;
            color: #666;
        }
    </style>
</head>
<body>
    <h1>Catálogo de Pictogramas</h1>
    
    <div class="pictogram-grid">
        @foreach($pictograms as $pictogram)
            <div class="pictogram-item">
                <img src="{{ asset($pictogram->imagen) }}" alt="{{ $pictogram->name }}">
                <div class="pictogram-path">

                    {{ asset('imagenes/' . $pictogram->imagen) }}
                    {{ asset($pictogram->categoria )}}
                    {{ asset($pictogram->descripcion )}}
                </div>
            </div>
        @endforeach
    </div>
</body>
</html>
