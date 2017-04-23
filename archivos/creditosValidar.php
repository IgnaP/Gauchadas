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
  $creditos=$fila[13];
  $creditos=$creditos + $_POST["cantCreds"];
  $sql="UPDATE `usuarios` SET `Creditos`='$creditos' WHERE `Email`='$email'";
  $resultado=mysqli_query($conexion,$sql);

  if($resultado==false){
    echo "Se produjo un error en la compra";
  } else {
    echo "exito";
  }
}
?>
