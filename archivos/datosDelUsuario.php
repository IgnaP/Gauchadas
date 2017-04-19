<?php
  session_start();
  require("conexionBD.php");
  conectarse($conexion);
  $email=$_SESSION["usuario"];
  $consulta="SELECT * FROM Usuarios WHERE Email='$email'";
  $resultado=mysqli_query($conexion,$consulta);
  $fila=mysqli_fetch_row($resultado);
  $nom=$fila[3];$ap=$fila[4];$fn=$fila[5];$tel=$fila[6];$pRep=$fila[12];
?>
