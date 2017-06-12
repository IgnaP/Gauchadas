<?php
require("conexionBD.php");
conectarse($conexion);
if (!$conexion) {
  $respuesta="Fallo al conectar con el servidor";
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
    if ( $_FILES["imagen"]["error"]==0 ) {
      require("funciones.php");
      $ok= subirImagen($nombre_imagen,$respuesta);
    } else {
      $ok= true;
    }
    if ($ok) {
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
      if ( isset( $nombre_imagen ) ) {
        $sql=$sql." ,`Imagen`='$nombre_imagen'";
      }
      $sql3=$sql." ".$sql2;
      if( mysqli_query($conexion,$sql3) ){
        $_SESSION["usuario"]=$nuevoMail;
        $respuesta="exito";
      } else {
        $respuesta="Se produjo un error al intentar cambiar los datos";
      }
    }
  } else {
    $respuesta="La clave es incorrecta";
  }
}
setcookie("pagina","miCuenta.php", time() + 3600, "/");
setcookie("respuesta", $respuesta, time() + 3600, "/");
header("Location: ../sesion.php");
?>
