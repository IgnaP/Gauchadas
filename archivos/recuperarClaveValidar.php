<?php
$email = $_POST["email"];
require("conexionBD.php");
conectarse($conexion);

if (!$conexion) {
  $arreglo = array('exito' => 'Fallo al conectar con el servidor');
  exit();
} else {
  $consulta="SELECT * FROM Usuarios WHERE Email='$email'";
  $resultado=mysqli_query($conexion,$consulta);
  $num_filas=mysqli_num_rows($resultado);
  if ($num_filas!=0) {
    $fila=mysqli_fetch_row($resultado);
    if ( isset($_POST["clave"]) ) {
      $clave = $_POST["clave"];
      $res = $_POST["resp"];
      if ($fila[8]==$res) {
        $con="UPDATE `usuarios` SET `Clave`='$clave' WHERE `Email`='$email'";
        if (mysqli_query($conexion,$con)) {
          $arreglo = array('exito' => 'exito');
        } else {
          $arreglo = array('exito' => 'Se ha producido un error al intentar cambiar la clave');
        }

      } else {
        $arreglo = array('exito' => 'La respuesta no es correcta');
      }
    } else {
      $pregID=$fila[7];
      $con="SELECT `Pregunta` FROM `preguntas` WHERE `ID`='$pregID'";
      $result=mysqli_query($conexion,$con);
      $row=mysqli_fetch_row($result);

      $arreglo = array('exito' => 'true', 'pregunta' => $row[0]);
    }
  } else {
    $arreglo = array('exito' => 'El mail ingresado no existe');
  }
}
$JSON = json_encode($arreglo);
echo $JSON;
?>
