<?php include ("template/cabecera.php"); ?>

<?php
/*En esta pagina se muestra la info de la base de datos
para todos los usuarios sin que estos puedan modificarla */

include("administrador/config/bd.php");
$sentenciaSQL=$conexion->prepare("SELECT * FROM productos");
$sentenciaSQL->execute();
$listaprod=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>

<?php foreach($listaprod as $prod) {?>

    <div class="col-md-3">
   
    <div class="card">
        <?php // Esta linea del codigo pone una imagen?>
        <img width = "200" height= "280"class="card-img-top" src="./img/<?php echo $prod['Imagen'];?>" alt="">
        <?php // Esto es el cuerpo por lo tanto es texto?>
        <div class="card-body">
            <h4 class="card-title"><?php echo $prod['Nombre'];?></h4>
            <h5 class="card-title"><?php echo $prod['Precio'];?></h4>>
           
        </div>
    </div>
    
</div>

<?php } ?>



<?php include ("template/pie.php"); ?>j