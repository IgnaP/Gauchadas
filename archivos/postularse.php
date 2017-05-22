<?php
require("conexionBD.php");
conectarse($conexion);
if (!$conexion) {
  echo "Fallo al conectar con el servidor";
  exit();
} else {
  session_start();
  $email = "homero@mail.com";
  $consulta="SELECT * FROM usuarios WHERE Email='$email'";
  $resultado= mysqli_query($conexion, $consulta);
  $fila=mysqli_fetch_row($resultado);
  $comentario= "Hola, me gustaria que me selecciones para realizarte el favor.";
  $IDpublicacion=1;
  $IDusuario= $fila[0];
  $consulta="INSERT INTO `postulantes` (`publicacionId`, `usuarioId`, `comentario`)
  VALUES ('$IDpublicacion', '$IDusuario', '$comentario')";
  $resultado=mysqli_query($conexion,$consulta);

  if($resultado==false){
    echo "Se produjo un error al postularse.";
  } else {
    echo "Se ha postulado correctamente.";
  }
}
?>
