<?php
require("conexionBD.php");
conectarse($conexion);
if (!$conexion) {
  echo "Fallo al conectar con el servidor";
  exit();
} else {
  session_start();
  $email = $_SESSION["usuario"];
  $clave = $_POST["clave"];
  $consulta="SELECT * FROM Usuarios WHERE Email='$email'";
  $resultado=mysqli_query($conexion,$consulta);
  $fila=mysqli_fetch_row($resultado);
  if($fila[2]==$clave){
    $nuevoMail = $_POST["nMail"];
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $nac = $_POST["fecha"];
    $tel = $_POST["telefono"];
    $pre = $_POST["preguntas"];
    $res = $_POST["respuesta"];

    $sql="SELECT ID FROM preguntas WHERE Pregunta='$pre'";
    $result=mysqli_query($conexion,$sql);
    $fila=mysqli_fetch_row($result);
    $preID=$fila[0];
    $sql="UPDATE `usuarios` SET `Email`='$nuevoMail',`Nombre`='$nombre',`Apellido`='$apellido',`FechaDeNacimiento`='$nac',`Telefono`='$tel',`PreguntaDeSeguridad`='$preID',`Respuesta`='$res'";
    $sql2="WHERE Email='$email'";
    if (isset($_POST["claveN"]) && ($_POST["claveN"]!="")) {
      $claveN = $_POST["claveN"];
      $sql=$sql." ,`Clave`='$claveN'";
    }
    $sql3=$sql." ".$sql2;
    $result=mysqli_query($conexion,$sql3);
    if($result){
      $_SESSION["usuario"]=$nuevoMail;
      echo "exito";
    } else {
      echo "Se produjo un error al intentar cambiar los datos $sql3";
    }
  } else {
    echo "La clave es incorrecta";
  }
}
?>
