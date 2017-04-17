<?php
$nombre = $_POST["nombre"];
$apellido = $_POST["apellido"];
$nac = $_POST["fecha"];
$tel = $_POST["telefono"];
$email = $_POST["email"];
$clave = $_POST["clave"];
$pregunta = $_POST["preguntas"];
$res = $_POST["respuesta"];

require("conexionBD.php");
conectarse($conexion);

if (!$conexion) {
  echo "Fallo al conectar con el servidor";
  exit();
} else {
  $sql="SELECT * FROM Usuarios WHERE Email='$email'";
  $resultado=mysqli_query($conexion,$sql);
  $num_filas=mysqli_num_rows($resultado);
  if ($num_filas==0) {

    # FALTA BUSCAR LA PREGUNTA EN LA BASE DE DATOS Y PASARLA A ID

    $sql="INSERT INTO `usuarios`(`Email`, `Clave`, `Nombre`, `Apellido`, `FechaDeNacimiento`, `Telefono`, `PreguntaDeSeguridad`, `Respuesta`)
          VALUES ('$email','$clave','$nombre','$apellido','$nac','$tel','$pregunta','$res')";
    $resultado=mysqli_query($conexion,$sql);

    if($resultado==false){
      echo "Se produjo un error al intentar guardar los datos";
    } else {
      session_start();
      $_SESSION["usuario"]=$email;
      echo "exito";
      #header("location:sesion.php");
    }
  } else {
    echo "El mail ingresado ya existe";
  }
}

?>
