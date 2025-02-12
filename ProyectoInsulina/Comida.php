<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <title><?php echo $titulo; ?></title>
    <style>
       .form-container {
            width: 50%;
            margin: auto;
            margin-top: 10%;
            padding: 20px;
            border: 2px solid #ccc;
            border-radius: 10px;
            background-color: #f9f9f9;
        }
    </style>
    </head>
    <body>
        <div class="form-container">
        <form>
            <div class="form-group row">
                <label for="inputComida" class="col-sm-2 col-form-label">Tipo Comida</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="inputComida" placeholder="Comida">
                </div>
            </div>
            <br>
            <div class="form-group row">
                <label for="inputgl1" class="col-sm-2 col-form-label">Glucosa1</label>
                <div class="col-sm-10">
                <input type="number" class="form-control" id="inputgl1" placeholder="glucosa1">
                </div>
            </div>
            <br>
            <div class="form-group row">
                <label for="inputgl2" class="col-sm-2 col-form-label">Glucosa2</label>
                <div class="col-sm-10">
                <input type="number" class="form-control" id="inputgl2" placeholder="glucosa2">
                </div>
            </div>
            <br>
            <div class="form-group row">
                <label for="inputraciones" class="col-sm-2 col-form-label">Raciones</label>
                <div class="col-sm-10">
                <input type="number" class="form-control" id="inputraciones" placeholder="raciones">
                </div>
            </div>
            <br>
            <div class="form-group row">
                <label for="inputinsulina" class="col-sm-2 col-form-label">Insulina</label>
                <div class="col-sm-10">
                <input type="number" class="form-control" id="inputinsulina" placeholder="insulina">
                </div>
            </div>
            <br>
            <div class="form-group row">
                <label for="inputFecha" class="col-sm-2 col-form-label">Fecha</label>
                <div class="col-sm-10">
                <input type="date" class="form-control" id="inputFecha" placeholder="">
                </div>
            </div>
            <br>
            <div class="form-group row">
                <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Confirmar</button>
                </div>
            </div>
        </form>
        </div>
    </body>
    </html>