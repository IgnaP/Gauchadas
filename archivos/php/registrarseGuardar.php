<?php
require("conexionBD.php");
conectarse($conexion);
if (!$conexion) {
  $respuesta="Fallo al conectar con el servidor";
} else {
  $nombre = $_POST["nombre"];
  $apellido = $_POST["apellido"];
  $nac = $_POST["fecha"];
  $tel = $_POST["telefono"];
  $email = $_POST["email"];
  $clave = $_POST["clave"];
  $pregunta = $_POST["preguntas"];
  $res = $_POST["respuesta"];
  if ( $_FILES["imagen"]["error"]==0 ) {
    require("funciones.php");
    $ok= subirImagen($nombre_imagen,$respuesta);
  } else {
    $ok= true;
  }
  if ($ok) {
    $sql="SELECT * FROM Usuarios WHERE Email='$email'";
    $resultado=mysqli_query($conexion,$sql);
    $num_filas=mysqli_num_rows($resultado);
    if ($num_filas==0) {

      $sql="SELECT ID FROM preguntas WHERE Pregunta='$pregunta'";
      $result=mysqli_query($conexion,$sql);
      $fila=mysqli_fetch_row($result);
      $preID=$fila[0];

      if ( isset( $nombre_imagen ) ) {
        $sql="INSERT INTO `usuarios`(`Email`, `Clave`, `Nombre`, `Apellido`, `FechaDeNacimiento`, `Telefono`, `PreguntaDeSeguridad`, `Respuesta`, `Imagen`)
              VALUES ('$email','$clave','$nombre','$apellido','$nac','$tel','$preID','$res','$nombre_imagen')";
      } else {
        $sql="INSERT INTO `usuarios`(`Email`, `Clave`, `Nombre`, `Apellido`, `FechaDeNacimiento`, `Telefono`, `PreguntaDeSeguridad`, `Respuesta`)
              VALUES ('$email','$clave','$nombre','$apellido','$nac','$tel','$preID','$res')";
      }
      $resultado=mysqli_query($conexion,$sql);

      if($resultado==false){
        $respuesta="Se produjo un error al intentar guardar los datos";
      } else {
        session_start();
        $_SESSION["usuario"]=$email;
        $respuesta="exito";
      }
    } else {
      $respuesta="El mail ingresado ya existe";
    }
  }
}
if ($respuesta=="exito") {
  header("Location: ../sesion.php");
} else {
  setcookie("pagina","registrarse.php", time() + 3600, "/");
  setcookie("respuesta", $respuesta, time() + 3600, "/");
  header("Location: ../index.php");
}
?>
