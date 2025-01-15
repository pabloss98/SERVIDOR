<?php
// Para comprobar la version: 
phpinfo();

if(extension_loaded('mongodb')){
    echo "La extensión MongoDB está cargada.";
}else{
    echo "La extensión MongoDB no está cargada.";
}

?>
