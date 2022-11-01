<?php 

function conectarDB(): mysqli {
    $db = new mysqli('localhost','root','root','bienesraices_crud');
    $db->set_charset('utf8');
    if(!$db){
        //No se conecto
        echo "Error no se pudo conecta a la base de datos";
        exit; //Detenemos la ejecucion
    }

    return $db;
}