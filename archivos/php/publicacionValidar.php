<?php
require("conexionBD.php");
conectarse($conexion);
if ( isset($_GET["pregunta"]) ) {
  session_start();
  $email=$_SESSION["usuario"];
  $sql2="SELECT `ID` FROM `usuarios` WHERE `Email`='$email'";
  $result2=mysqli_query($conexion, $sql2);
  $row2 = mysqli_fetch_row($result2);
  $usrID=$row2[0];
  $pID=$_GET["pregunta"];
  $preg=$_POST["inpPregunta"];
  $sql="INSERT INTO `comentarios`(`Pregunta`, `Publicacion`, `UsuarioID`) VALUES ('$preg','$pID','$usrID')";
  $result=mysqli_query($conexion, $sql);
  if ($result) {
    echo "exito";
    $sql2="UPDATE `publicaciones` SET `Vista`='0' WHERE `ID`='$pID'";
    mysqli_query($conexion, $sql2);
  } else {
    echo "Se ha producido un error";
  }
}elseif ( isset($_GET["cargar"]) ) {
  $pID=$_GET["cargar"];
  $sql="SELECT `ID`, `Pregunta`, `Respuesta` , `UsuarioID` FROM `comentarios` WHERE `Publicacion`='$pID'";
  $result=mysqli_query($conexion, $sql);
  $cont=0;
  $arreglo= array();
  while ($row = mysqli_fetch_row($result)) {
    $usrID=$row[3];
    $sql2="SELECT `Email` FROM `usuarios` WHERE `ID`='$usrID'";
    $result2=mysqli_query($conexion, $sql2);
    $row2 = mysqli_fetch_row($result2);
    $row[3]=$row2[0];
    $arreglo[$cont] = $row;
    $cont=$cont+1;
  }
  $jDatos = json_encode($arreglo);
  echo $jDatos;
}elseif ( isset($_GET["respuesta"]) ) {
  $res=$_POST["inpRespuesta"];
  $comID=$_POST["inpConID"];
  $sql="UPDATE `comentarios` SET `Respuesta`='$res',`Vista`='0' WHERE `ID`='$comID'";
  $result=mysqli_query($conexion, $sql);
  if ($result) {
    echo "exito";
  } else {
    echo "Se ha producido un error";
  }
}
?>
