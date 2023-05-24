<?php 
//cierra la sesion del usuario y redirecciona al formulario para logearte
session_start();
session_destroy();
header('Location:../../index.php');
?>