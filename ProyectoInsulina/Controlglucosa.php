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
                <label for="inputFecha" class="col-sm-2 col-form-label">Fecha</label>
                <div class="col-sm-10">
                <input type="date" class="form-control" id="inputFecha" placeholder="">
                </div>
            </div>
            <br>
            <div class="form-group row">
                <label for="inputDeporte" class="col-sm-2 col-form-label">Deporte</label>
                <div class="col-sm-10">
                <input type="number" class="form-control" id="inputDeporte" placeholder="Deporte">
                </div>
            </div>
            <br>
            <div class="form-group row">
                <label for="inputlenta" class="col-sm-2 col-form-label">Lenta</label>
                <div class="col-sm-10">
                <input type="number" class="form-control" id="inputLenta" placeholder="Lenta">
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