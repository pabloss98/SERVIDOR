<?php 
    $email="abc@abc.com";
    $emailErr="Email correcto"; 
    if (empty($email)) {    
        $emailErr = "Se requiere Email";   
        } else {         
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {    
                $emailErr = "Fomato de Email invalido"; 
                    } 
                } 
                    echo $email; echo "<br>"; echo $emailErr;
?> 