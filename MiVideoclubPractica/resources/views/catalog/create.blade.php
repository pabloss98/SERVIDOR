<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="{{route('catalog.store')}}" method="post">
        {{ csrf_field()}}
        <label for="title">Title:</label>
        <input type="text" name="title" id="title">
        <br>
        <label for="year">Year:</label>
        <input type="text" name="year" id="year">
        <br>
        <label for="director">Director:</label>
        <input type="text" name="director" id="director">
        <br>
        <label for="poster">Poster:</label>
        <input type="text" name="poster" id="poster">
        <br>
        <label for="synopsis">Synopsis:</label>
        <input type="text" name="synopsis" id="synopsis">
        <br>
        <input type="submit" value="Create">
</body>
</html>