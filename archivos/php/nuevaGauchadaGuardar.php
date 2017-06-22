<?php
require("conexionBD.php");
conectarse($conexion);
setcookie("pagina","nuevaGauchada.php", time() + 3600, "/");
if (!$conexion) {
  $respuesta="Fallo al conectar con el servidor";
} else {
  session_start();
  $email = $_SESSION["usuario"];
  $consulta="SELECT * FROM Usuarios WHERE Email='$email'";
  $resultado=mysqli_query($conexion,$consulta);
  $fila=mysqli_fetch_row($resultado);
  $creditos=$fila[13];
  if ($creditos>0) {
    if ( $_FILES["imagen"]["error"]==0 ) {
      require("funciones.php");
      $ok= subirImagen($nombre_imagen,$respuesta);
    } else {
      $ok= true;
    }
    if ($ok) {
      $tit = $_POST["titulo"];
      $prov = $_POST["provincias"];
      $ciu = $_POST["ciudad"];
      $fec = $_POST["fecha"];
      $cat = $_POST["categoria"];
      $des = $_POST["descrip"];

      $sql="SELECT `ID` FROM `usuarios` WHERE `Email`='$email'";
      $result=mysqli_query($conexion,$sql);
      $row = mysqli_fetch_row($result);
      $usrID=$row[0];
      $sql="SELECT localidades.id FROM (localidades INNER JOIN provincias ON (provincias.id=localidades.id_provincia)) WHERE `localidad`='$ciu' AND provincia='$prov'";
      $result=mysqli_query($conexion,$sql);
      $row = mysqli_fetch_row($result);
      $ciuID=$row[0];
      $sql="SELECT `ID` FROM `categorias` WHERE `Nombre`='$cat'";
      $result=mysqli_query($conexion,$sql);
      $row = mysqli_fetch_row($result);
      $catID=$row[0];
      if ( isset( $nombre_imagen ) ) {
        $sql="INSERT INTO `publicaciones`(`Nombre`, `Ciudad`, `FechaLimite`, `Categoria`, `Descripcion`, `usuario`, `Imagen`)
                                VALUES ('$tit','$ciuID','$fec','$catID','$des','$usrID','$nombre_imagen')";
      } else {
        $sql="INSERT INTO `publicaciones`(`Nombre`, `Ciudad`, `FechaLimite`, `Categoria`, `Descripcion`, `usuario`)
                                VALUES ('$tit','$ciuID','$fec','$catID','$des','$usrID')";
      }
      $resultado=mysqli_query($conexion,$sql);

      if($resultado==false){
        $respuesta="Se produjo un error al intentar agregar la gauchada";
      } else {
        $creditos=$creditos-1;
        $sql="UPDATE `usuarios` SET `Creditos`='$creditos' WHERE `Email`='$email'";
        $resultado=mysqli_query($conexion,$sql);
        $respuesta="exito";
      }
    }
  } else {
    $respuesta="Creditos insuficientes";
  }
}
setcookie("respuesta", $respuesta, time() + 3600, "/");
header("Location: ../sesion.php");
?>
