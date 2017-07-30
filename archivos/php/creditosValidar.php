<?php
require("conexionBD.php");
conectarse($conexion);
if (!$conexion) {
  echo "Fallo al conectar con el servidor";
  exit();
} else {
  session_start();
  $email = $_SESSION["usuario"];
  $consulta="SELECT * FROM Usuarios WHERE Email='$email'";
  $resultado=mysqli_query($conexion,$consulta);
  $fila=mysqli_fetch_row($resultado);
  $id_usuario=$fila[0];
  $creditos=$fila[13];
  $cant=$_POST["cantCreds"];
  $creditos=$creditos + $cant;
  $sql="UPDATE `usuarios` SET `Creditos`='$creditos' WHERE `Email`='$email'";
  $resultado=mysqli_query($conexion,$sql);
  $sql="SELECT * FROM `credito`";
  $creditos=mysqli_query($conexion, $sql);
  $filaCredito=mysqli_fetch_row($creditos);
  $id_credito=$filaCredito[0];
  $sql="INSERT INTO `compra_creditos`(`ID_usuario`,`ID_credito`,`Cantidad`) VALUES ('$id_usuario','$id_credito','$cant')";
  $compraCredito=mysqli_query($conexion , $sql);
  if($resultado==false){
    echo "Se produjo un error en la compra";
  } else {
    echo "exito";
  }
}
?>
