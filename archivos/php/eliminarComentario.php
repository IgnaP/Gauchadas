<?php
  require("conexionBD.php");
  conectarse($conexion);
  $id = $_POST["id"];
  if ( $_POST["tipo"]=="preg" ) {
    $sql="DELETE FROM `comentarios` WHERE `ID`='$id'";
  } else {
    $sql="UPDATE `comentarios` SET `Respuesta`='' WHERE `ID`='$id'";
  }
  mysqli_query($conexion,$sql);
?>
