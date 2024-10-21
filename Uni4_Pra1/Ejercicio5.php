
 
 <form action='resultadofordinamico.php' method='get'>
 <?php
for($i = 0;$i < 9; $i++){
    echo <<<_END

    <label for="$i">$i:</label>

    <input type="text" id="caja0" name = "$i"><br><br>
    _END;
}

echo <<<_END
    <input type="submit" value="Enviar">
    _END;

?>

