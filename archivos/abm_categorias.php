<?php
require("php/conexionBD.php");
conectarse($conexion);
if ($conexion) {
  $funcion=$_POST["funcion"];
  if($funcion=="eliminar"){
      $dato=$_POST["nombreCategoria"];
        $sql="UPDATE `categorias` SET `vigente`= 0 WHERE `Nombre`= '$dato'";
        $resultado = mysqli_query($conexion, $sql);
        $borrado='t';
      setcookie('categoriaEli', $borrado, time() + 3600, "/");
}elseif ($funcion== "crear") {
  $nombre=$_POST["nombre"];
  $sql="SELECT * FROM `categorias` WHERE `categorias`.`Nombre` = '$nombre' AND`categorias`.`vigente`=1";
  $resultado=mysqli_query($conexion, $sql);
  $cant=mysqli_num_rows($resultado);
  if( $cant==0){
    $sql="INSERT INTO `categorias`(`Nombre`) VALUES ('$nombre')";
    $resultado=mysqli_query($conexion,$sql);
    $agregado='t';
  }else{
    $agregado="El nombre ingresado ya le pertenece a una categoria actual.";
  }
  setcookie('categoriaAlta', $agregado, time() + 3600, "/");
}else{
  $nombreNuevo=$_POST["nombre"];
  $nombreViejo=$_POST["nombreCategoria"];
  $sql="SELECT * FROM `categorias` WHERE `categorias`.`Nombre` = '$nombreNuevo' AND `categorias`.`vigente`=1";
  $resultado=mysqli_query($conexion, $sql);
  $cant=mysqli_num_rows($resultado);
if($cant == 0){
  $sql="UPDATE `categorias` SET `Nombre`='$nombreNuevo' WHERE `categorias`.`Nombre`= '$nombreViejo'";
  $resultado= mysqli_query($conexion, $sql);
  $modificado='t';
}else{
  $modificado= "El nombre ingresado ya le pertenece a una categoria actual";
}
setcookie('categoriaModi', $modificado, time() + 3600, "/");
}
}

 ?>
