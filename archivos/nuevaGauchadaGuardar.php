<?php
session_start();
$tit = $_POST["titulo"];
$ciu = $_POST["ciudad"];
$fec = $_POST["fecha"];
$cat = $_POST["categoria"];
$des = $_POST["descrip"];
#$img = $_POST["imagen"];
$email = $_SESSION["usuario"];

require("conexionBD.php");
conectarse($conexion);

if (!$conexion) {
  echo "Fallo al conectar con el servidor";
  exit();
} else {
  $sql="SELECT `ID` FROM `usuarios` WHERE `Email`='$email'";
  $result=mysqli_query($conexion,$sql);
  $row = mysqli_fetch_row($result);
  $usrID=$row[0];
  $sql="SELECT `ID` FROM `ciudades` WHERE `Nombre`='$ciu'";
  $result=mysqli_query($conexion,$sql);
  $row = mysqli_fetch_row($result);
  $ciuID=$row[0];
  $sql="SELECT `ID` FROM `categorias` WHERE `Nombre`='$cat'";
  $result=mysqli_query($conexion,$sql);
  $row = mysqli_fetch_row($result);
  $catID=$row[0];

  $sql="INSERT INTO `publicaciones`(`Nombre`, `Ciudad`, `FechaLimite`, `Categoria`, `Descripcion`, `usuario`)
                          VALUES ('$tit','$ciuID','$fec','$catID','$des','$usrID')";
  $resultado=mysqli_query($conexion,$sql);

  if($resultado==false){
    echo "Se produjo un error al intentar agregar la gauchada";
  } else {
    echo "exito";
  }
}
?>
