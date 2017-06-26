<?php
require("php/conexionBD.php");
conectarse($conexion);
if ($conexion) {
  $funcion=$_GET["funcion"];
  $sql="SELECT * FROM `reputacion` WHERE `reputacion`.`Puntos` = (SELECT MIN(Puntos) FROM `reputacion` WHERE `reputacion`.`vigente`=0)";
  $resultado= mysqli_query($conexion,$sql);
  $filaMin=mysqli_fetch_row($resultado);
  $sql="SELECT * FROM `reputacion` WHERE `reputacion`.`Puntos` = (SELECT MAX(Puntos) FROM `reputacion` WHERE `reputacion`.`vigente`=0)";
  $resultado= mysqli_query($conexion, $sql);
  $filaMax=mysqli_fetch_row($resultado);
  if($funcion=="eliminar"){
      $dato=$_GET["nombreRepu"];
      if($dato==$filaMin[1] || $dato==$filaMax[1]){
        $sql="UPDATE `reputacion` SET `vigente`= 1 WHERE `Nombre`= '$dato'";
        $resultado = mysqli_query($conexion, $sql);
        $borrado='t';
      } else {
        $borrado='f';
      }
      $array = array('borrado' => "$borrado");

    }elseif ($funcion== "crear") {
      $p1=$_GET["puntaje1"];
      $nombre=$_GET["nombre"];
      $sql="SELECT * FROM `reputacion` WHERE `reputacion`.`Nombre` = '$nombre'";
      $resultado=mysqli_query($conexion, $sql);
      $cant=mysqli_num_rows($resultado);
      if($p1 < $filaMin[2] || $filaMax[2]<$p1){
        $p1valido='t';
      }else{
        $p1valido='f';
      }
      if($p1valido=='t' && $cant==0){
        $sql="INSERT INTO `reputacion`(`Nombre`,`Puntos`) VALUES ('$nombre','$p1')";
        $resultado=mysqli_query($conexion,$sql);
      }
      $array= array('Existe' => "$cant", 'p1Valido' => "$p1valido");
    }
    $jDatos = json_encode($array);
    echo $jDatos;
  }
 ?>
