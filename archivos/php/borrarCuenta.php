<?php
  require("conexionBD.php");
  conectarse($conexion);
  session_start();
  $email=$_SESSION["usuario"];
  $clave = $_POST["clave"];

  $consulta="SELECT * FROM Usuarios WHERE Email='$email'";
  $resultado=mysqli_query($conexion,$consulta);
  $fila=mysqli_fetch_row($resultado);
  if($fila[2]==$clave){
    $sql="UPDATE `usuarios` SET `Borrada`='1' WHERE `Email`='$email'";
    $resultado=mysqli_query($conexion,$sql);
    if($resultado){
      $usrID=$fila[0];
      $sql="UPDATE `publicaciones` SET `Activa`=0 WHERE `usuario`='$usrID'";
      mysqli_query($conexion,$sql);
      echo "exito";
      session_destroy();
    } else {
      echo "Se produjo un error al intentar borrar la cuenta";
    }
  } else {
    echo "La clave es incorrecta";
  }
?>
