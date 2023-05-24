<?php include("../template/cabecera.php");?>
<?php 

$txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
$txtNombre=(isset($_POST['txtNombre']))?$_POST['txtNombre']:"";
$txtPrecio=(isset($_POST['txtPrecio']))?$_POST['txtPrecio']:"";
$txtImagen=(isset($_FILES['txtImagen']['name']))?$_FILES['txtImagen']['name']:"";
$accion=(isset($_POST['accion']))?$_POST['accion']:"";

include("../config/bd.php");
//INSERT INTO `productos` (`Id`, `Nombre`, `Precio`, `Imagen`) VALUES (NULL, 'Silla de ruedas', '1200.00', 'perroMot.png');
//las funciones que hara cada boton 
switch($accion){
        
        case "Agregar":
            $sentenciaSQL= $conexion->prepare("INSERT INTO Productos (nombre, precio, imagen) VALUES (:nombre,:precio, :imagen);");
            $sentenciaSQL->bindParam(':nombre',$txtNombre);
            $sentenciaSQL->bindParam(':precio',$txtPrecio);

            $fecha = new DateTime();
            $nombreArchivo = ($txtImagen != "")?$fecha ->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";

            $tmpImagen=$_FILES["txtImagen"]["tmp_name"];

            if($tmpImagen != ""){

                move_uploaded_file($tmpImagen, "../../img/". $nombreArchivo);

            }

            $sentenciaSQL->bindParam(':imagen',$nombreArchivo);
            $sentenciaSQL-> execute();    

            header("Location:productos.php");

            echo "Presionado botón agregar";
            break;

        case "Modificar":
            $sentenciaSQL=$conexion->prepare("UPDATE productos SET nombre =:nombre, precio = :precio WHERE id = :id");
            $sentenciaSQL -> bindParam(':nombre', $txtNombre);
            $sentenciaSQL->bindParam(':precio',$txtPrecio);
            $sentenciaSQL -> bindParam(':id', $txtID);
            $sentenciaSQL->execute();
            
            if($txtImagen != ""){

                $fecha = new DateTime();
                $nombreArchivo = ($txtImagen != "")?$fecha ->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";
                $tmpImagen=$_FILES["txtImagen"]["tmp_name"];

                move_uploaded_file($tmpImagen, "../../img/". $nombreArchivo);

                $sentenciaSQL=$conexion->prepare("SELECT imagen FROM productos WHERE id = :id");
                $sentenciaSQL -> bindParam(':id', $txtID);
                $sentenciaSQL->execute();
                $objeto=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

                if( isset($objeto["imagen"]) && ($objeto["imagen"] != "imagen.jpg") ){

                    if(file_exists("../../img/".$objeto["imagen"])){

                        unlink("../../img/".$objeto["imagen"]);
                     }

                }

                $sentenciaSQL=$conexion->prepare("UPDATE Productos SET imagen =:imagen WHERE id = :id");
                $sentenciaSQL -> bindParam(':imagen', $nombreArchivo);
                $sentenciaSQL -> bindParam(':id', $txtID);
                $sentenciaSQL->execute();
            }

            header("Location:productos.php");
            break;

        case "Cancelar":
            header("Location:productos.php");
            break;

        case "Seleccionar":
            // echo "Presionado botón seleccionar";
            $sentenciaSQL=$conexion->prepare("SELECT * FROM productos WHERE id = :id");
            $sentenciaSQL -> bindParam(':id', $txtID);
            $sentenciaSQL->execute();
            $objeto=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

            $txtNombre = $objeto['Nombre'];
            $txtPrecio = $objeto['Precio'];
            $txtImagen = $objeto['Imagen'];
            break;

        case "Borrar":
            // echo "Presionado botón borrar";
            $sentenciaSQL=$conexion->prepare("SELECT imagen FROM productos WHERE id = :id");
            $sentenciaSQL -> bindParam(':id', $txtID);
            $sentenciaSQL->execute();
            $objeto=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

            if( isset($objeto["imagen"]) && ($objeto["imagen"] != "imagen.jpg") ){

                if(file_exists("../../img/".$objeto["imagen"])){

                    unlink("../../img/".$objeto["imagen"]);
                }

            }


            $sentenciaSQL=$conexion->prepare("DELETE FROM productos WHERE id = :id");
            $sentenciaSQL->bindParam(':id',$txtID);
            $sentenciaSQL->execute();
            header("Location:productos.php");
            break;
                        
            
}

$sentenciaSQL = $conexion -> prepare("SELECT * FROM productos");
$sentenciaSQL -> execute();
$listaprod=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

?>

<?php
//Este es el formulario donde se pondra la informacion para ser mandada a la base de datos 
?>
<div class="col-md-5">
    
    <div class="card">
        <div class="card-header">
            Datos de Libro
        </div>

        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">

                <div class = "form-group">
                    <label for="txtID">ID:</label>
                    <input type="text" required readonly class="form-control" value = "<?php echo $txtID;?>" name="txtID" id="txtID" placeholder="ID">
                </div>

                <div class = "form-group">
                    <label for="txtNombre">Nombre:</label>
                    <input type="text" required class="form-control" value = "<?php echo $txtNombre;?>" name="txtNombre" id="txtNombre" placeholder="Nombre del Product">
                </div>

                <div class = "form-group">
                    <label for="txtNombre">Precio:</label>
                    <input type="text" required class="form-control" value = "<?php echo $txtPrecio;?>" name="txtPrecio" id="txtPrecio" placeholder="Precio del Product">
                </div>

                <div class = "form-group">
                    <label for="txtNombre">Imagen:</label>

                    <br/>

                    <?php if($txtImagen!=""){ ?>
                    
                        <img class="img-thumbnail rounded" src= "../../img/<?php echo $txtImagen;?>" width="50" alt= "" srcset="">

                    <?php }  ?>

                    <input type="file"  class="form-control" name="txtImagen" id="txtImagen" placeholder="Nombre del libro">
                </div>

                <div class="btn-group" role="group" aria-label="">
                    <button type="submit" name="accion" <?php echo ($accion == "Seleccionar")?"disabled":"";?> value="Agregar" class="btn btn-success">Agregar</button>
                    <button type="submit" name="accion" <?php echo ($accion != "Seleccionar")?"disabled":"";?> value="Modificar" class="btn btn-warning">Modificar</button>
                    <button type="submit" name="accion" <?php echo ($accion != "Seleccionar")?"disabled":"";?> value="Cancelar" class="btn btn-info">Cancelar</button>
                </div>

            </form>
        </div>
    </div>   
</div>

<?php 
//Esta es la tabla donde aparece la info que se mando
?>
<div class ="col-md-7">
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($listaprod as $prod) { ?>
            <tr>
                <td><?php echo $prod['Id'];?></td>
                <td><?php echo $prod['Nombre']; ?></td>
                <td><?php echo $prod['Precio'];?> </td>
                <td>
                    
                <img class="img-thumbnail rounded" src= "../../img/<?php echo $prod['Imagen']; ?>" width="50" alt= "" srcset="">
                
                </td>
                
                <td>
                    
                    <form  method="post">

                        <input type="hidden" name="txtID" id="txtID" value="<?php echo $prod['Id'];?>" />
                        
                        <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary" />

                        <input type="submit" name="accion" value="Borrar" class="btn btn-danger" />

                    </form>
                </td>
            
            </tr>
            <?php }?>
        </tbody>
    </table>
</div>

<?php include("../template/pie.php");?>