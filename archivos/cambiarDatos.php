<?php
session_start();
$nombre = $_POST["nombre"];
$apellido = $_POST["apellido"];
$nac = $_POST["fecha"];
$tel = $_POST["telefono"];
$email = $_SESSION["usuario"];
#$clave = $_POST["clave"];
#$pregunta = $_POST["preguntas"];
#$res = $_POST["respuesta"];

require("conexionBD.php");
conectarse($conexion);

if (!$conexion) {
  echo "Fallo al conectar con el servidor";
  exit();
} else {
  $sql="UPDATE `usuarios`
        SET `Nombre`='$nombre',`Apellido`='$apellido',`FechaDeNacimiento`='$nac',`Telefono`='$tel'
        WHERE Email='$email'";
  $resultado=mysqli_query($conexion,$sql);

  if($resultado==false){
    echo "Se produjo un error al intentar cambiar los datos";
  } else {
    $_SESSION["nombre"]=$nombre;
    $_SESSION["apellido"]=$apellido;
    $_SESSION["fn"]=$nac;
    $_SESSION["tel"]=$tel;
    echo "exito";
  }
}
?>
