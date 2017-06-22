<?php
require("conexionBD.php");
conectarse($conexion);
if (!$conexion) {
  $respuesta="Fallo al conectar con el servidor";
} else {
  if ( $_FILES["imagen"]["error"]==0 ) {
    require("funciones.php");
    $ok= subirImagen($nombre_imagen,$respuesta);
  } else {
    $ok= true;
  }
  if ($ok) {
    $pID = $_COOKIE["modificarGauchada"];
    $tit = $_POST["titulo"];
    $prov = $_POST["provincias"];
    $ciu = $_POST["ciudad"];
    $fec = $_POST["fecha"];
    $cat = $_POST["categoria"];
    $des = $_POST["descrip"];
    $sql="SELECT localidades.id FROM (localidades INNER JOIN provincias ON (provincias.id=localidades.id_provincia)) WHERE `localidad`='$ciu' AND provincia='$prov'";
    $result=mysqli_query($conexion,$sql);
    $row = mysqli_fetch_row($result);
    $ciuID=$row[0];
    $sql="SELECT `ID` FROM `categorias` WHERE `Nombre`='$cat'";
    $result=mysqli_query($conexion,$sql);
    $row = mysqli_fetch_row($result);
    $catID=$row[0];
    if ( isset( $nombre_imagen ) ) {
      $sql="UPDATE `publicaciones`
            SET `Nombre`='$tit',`Ciudad`='$ciuID',`FechaLimite`='$fec',`Categoria`='$catID',`Descripcion`='$des',`Imagen`='$nombre_imagen'
            WHERE `ID`='$pID'";
    } else {
      $sql="UPDATE `publicaciones`
            SET `Nombre`='$tit',`Ciudad`='$ciuID',`FechaLimite`='$fec',`Categoria`='$catID',`Descripcion`='$des'
            WHERE `ID`='$pID'";
    }
    if( mysqli_query($conexion,$sql) ){
      $respuesta="exito";
    } else {
      $respuesta="Se produjo un error al intentar cambiar los datos";
    }
  }
}
setcookie("pagina","modificarGauchada.php", time() + 3600, "/");
setcookie("respuesta", $respuesta, time() + 3600, "/");
header("Location: ../sesion.php");
?>
