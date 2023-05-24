<?php
// se conecta a la base de datos para ser utilizada
$host_db="localhost";
$name_db="sitio";
$user_db="root";
$pass_db="";

  try{
    $conexion= new PDO("mysql:host=$host_db;dbname=$name_db", $user_db, $pass_db);
    //if($conexion){echo "Conectando... ahora";}
  }catch(Exception $ex){
    echo $ex ->getMessage();
  }

?>