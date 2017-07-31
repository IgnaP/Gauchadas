<?php
require("php/conexionBD.php");
conectarse($conexion);
if ($conexion) {
  $precioNuevo= $_POST["precio"];

  // Pongo en NO vigente a la tarifa anterior.
  $consulta="UPDATE `credito` SET `Vigente`= 1 WHERE `credito`.`Vigente`= 0";
  $resultado=mysqli_query($conexion,$consulta);

  // Agrego la nueva tarifa.
  $consulta="INSERT INTO `credito`(`Precio`) VALUES ('$precioNuevo')";
  $resultado=mysqli_query($conexion,$consulta);

}

?>
