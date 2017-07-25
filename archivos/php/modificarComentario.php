<?php
  require("conexionBD.php");
  conectarse($conexion);
  $id = $_POST["id"];
  $texto = $_POST["texto"];
  if ( $_POST["tipo"]=="preg" ) {
    $sql="UPDATE `comentarios` SET `Pregunta`='$texto' WHERE `ID`='$id'";
  } else {
    $sql="UPDATE `comentarios` SET `Respuesta`='$texto' WHERE `ID`='$id'";
  }
  mysqli_query($conexion,$sql);
?>
