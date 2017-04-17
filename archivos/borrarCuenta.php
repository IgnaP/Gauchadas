<?php
  session_start();

  require("conexionBD.php");
  conectarse($conexion);

  $sql="UPDATE `usuarios` SET `Borrada`='1' WHERE `Email`='$_SESSION[usuario]'";
  $resultado=mysqli_query($conexion,$sql);
  if($resultado==false){
    echo "Se produjo un error al intentar borrar la cuenta";
  } else {
    echo "exito";
    session_destroy();
  }
?>
