<!DOCTYPE html>
<html>
<head>
    <title>3 en Raya</title>
    <style>
        .grid {
            display: grid;
            grid-template-columns: repeat(3, 100px);
            grid-gap: 5px;
        }
        .cell {
            width: 100px;
            height: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2em;
            background-color: #f0f0f0;
            cursor: pointer;
            border: 1px solid #333;
        }
    </style>
</head>
<body>
    <?php
    // Inicializar tablero y turno
    session_start();
    if (!isset($_SESSION['board'])) {
        $_SESSION['board'] = array_fill(0, 9, '');
        $_SESSION['turn'] = 'X';
    }
    $board = $_SESSION['board'];
    $turn = $_SESSION['turn'];
    $winner = null;

    // Función para verificar si hay un ganador
    function check_winner($board) {
        $winning_combinations = [
            [0, 1, 2], [3, 4, 5], [6, 7, 8], // Filas
            [0, 3, 6], [1, 4, 7], [2, 5, 8], // Columnas
            [0, 4, 8], [2, 4, 6]             // Diagonales
        ];
        foreach ($winning_combinations as $combo) {
            if ($board[$combo[0]] !== '' && 
                $board[$combo[0]] === $board[$combo[1]] && 
                $board[$combo[1]] === $board[$combo[2]]) {
                return $board[$combo[0]];
            }
        }
        return null;
    }

    // Manejar clic en celda
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cell'])) {
        $cell = (int)$_POST['cell'];
        if ($board[$cell] === '' && !$winner) {
            $board[$cell] = $turn;
            $_SESSION['board'] = $board;
            $winner = check_winner($board);
            if ($winner) {
                echo "<h2>¡El ganador es $winner!</h2>";
            } elseif (!in_array('', $board)) {
                echo "<h2>¡Es un empate!</h2>";
            } else {
                $turn = $turn === 'X' ? 'O' : 'X';
                $_SESSION['turn'] = $turn;
            }
        }
    }

    // Reiniciar el juego
    if (isset($_POST['reset'])) {
        $_SESSION['board'] = array_fill(0, 9, '');
        $_SESSION['turn'] = 'X';
        header("Location: " . $_SERVER['PHP_SELF']);
    }
    ?>

    <h1>Juego de 3 en Raya</h1>
    <form method="post">
        <div class="grid">
            <?php
            for ($i = 0; $i < 9; $i++) {
                echo "<button type='submit' name='cell' value='$i' class='cell'>" . htmlspecialchars($board[$i]) . "</button>";
            }
            ?>
        </div>
        <br>
        <button type="submit" name="reset">Reiniciar Juego</button>
    </form>
</body>
</html>
