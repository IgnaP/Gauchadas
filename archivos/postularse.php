<?php
require("php/conexionBD.php");
conectarse($conexion);
if (!$conexion) {
  echo "Fallo al conectar con el servidor";
  exit();
} else {
  session_start();
  $IDpublicacion= $_POST["pID"];
  $email = $_SESSION["usuario"];
  $comentario= $_POST["coment"];
  $consulta="SELECT * FROM usuarios WHERE Email='$email'";
  $resultado= mysqli_query($conexion, $consulta);
  $fila=mysqli_fetch_row($resultado);
  $IDusuario= $fila[0];
  $consulta="INSERT INTO `postulantes` (`publicacionId`, `usuarioId`, `comentario`)
  VALUES ('$IDpublicacion', '$IDusuario', '$comentario')";
  $resultado=mysqli_query($conexion,$consulta);
  if($resultado==false){
    echo "Se produjo un error al postularse";
  } else {
    echo "exito";
  }
}
?>
