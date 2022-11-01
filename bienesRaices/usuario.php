<?php  

//Borrar una vez finalizado el proyecto (SOLO SIRVE PARA CREAR UN USUARIO)

//Importar la conexion
require 'includes/app.php';
$db = conectarDB();

//Crear un email y password
$email = "correo@correo.com";
$password = "123456";

$passwordHash = password_hash($password, PASSWORD_DEFAULT);


//Query para crear el usuario
$query = " INSERT INTO usuarios (email, password) VALUES ( '${email}', '${passwordHash}');";

//Agregarlo a la base de datos

mysqli_query($db,$query);