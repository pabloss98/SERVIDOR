<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calendario PHP</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            width: 14.28%;
            height: 50px;
            text-align: center;
            border: 1px solid #333;
        }
        th {
            background-color: #f2f2f2;
        }
        .empty {
            background-color: #e0e0e0;
        }
    </style>
</head>
<body>

<h2>Generador de Calendario</h2>
<form method="POST">
    <label for="mes">Mes:</label>
    <input type="number" id="mes" name="mes" min="1" max="12" required>
    <label for="anio">Año:</label>
    <input type="number" id="anio" name="anio" min="1900" max="2100" required>
    <button type="submit">Enviar</button>
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mes = intval($_POST["mes"]);
    $anio = intval($_POST["anio"]);

    if ($mes >= 1 && $mes <= 12 && $anio >= 1900 && $anio <= 2100) {
        $primerDiaMes = mktime(0, 0, 0, $mes, 1, $anio);
        $diasEnMes = date("t", $primerDiaMes);
        $diaInicioSemana = date("N", $primerDiaMes); // 1 (lunes) a 7 (domingo)

        echo "<h3>Calendario de " . date("F Y", $primerDiaMes) . "</h3>";
        echo "<table>";
        echo "<tr><th>Lunes</th><th>Martes</th><th>Miércoles</th><th>Jueves</th><th>Viernes</th><th>Sábado</th><th>Domingo</th></tr><tr>";

        for ($i = 1; $i < $diaInicioSemana; $i++) {
            echo "<td class='empty'></td>";
        }

        for ($dia = 1; $dia <= $diasEnMes; $dia++) {
            echo "<td>$dia</td>";
            if (($dia + $diaInicioSemana - 1) % 7 == 0) {
                echo "</tr><tr>";
            }
        }

        while (($dia + $diaInicioSemana - 1) % 7 != 0) {
            echo "<td class='empty'></td>";
            $dia++;
        }

        echo "</tr></table>";
    } else {
        echo "<p>Por favor, introduce un mes entre 1 y 12 y un año válido.</p>";
    }
}
?>

</body>
</html>
