<?php
require("php/conexionBD.php");
conectarse($conexion);
if ($conexion) {
  $funcion=$_POST["funcion"];
  if($funcion=="eliminar"){
      $dato=$_POST["nombreRepu"];
        $sql="UPDATE `reputacion` SET `vigente`= 1 WHERE `Nombre`= '$dato'";
        $resultado = mysqli_query($conexion, $sql);
        $borrado='t';
      setcookie('respuestaEli', $borrado, time() + 3600, "/");

    }elseif ($funcion== "crear") {
      $p1=$_POST["puntaje1"];
      $nombre=$_POST["nombre"];
      $sql="SELECT * FROM `reputacion` WHERE `reputacion`.`Nombre` = '$nombre'";
      $resultado=mysqli_query($conexion, $sql);
      $cant=mysqli_num_rows($resultado);
      $sql="SELECT * FROM `reputacion` WHERE `reputacion`.`Puntos` = '$p1'";
      $result=mysqli_query($conexion,$sql);
      $pRepetido=mysqli_num_rows($result);
      if($pRepetido == 0){
          $p1valido='t';
        }else{
          $p1valido='f';
        }
      if($p1valido=='t' && $cant==0){
        $sql="INSERT INTO `reputacion`(`Nombre`,`Puntos`) VALUES ('$nombre','$p1')";
        $resultado=mysqli_query($conexion,$sql);
        $agregado='t';
      }elseif ($p1valido == 'f' && $cant>0) {
        $agregado="El nombre ingresado ya le pertenece a una reputacion actual y el puntaje
        elegido ya esta dentro de los rangos actuales";
      }elseif ($p1valido == 'f') {
        $agregado="El puntaje ingresado ya da comienzo a uno de los rangos actuales.";
      }else{
        $agregado="El nombre ingresado ya le pertenece a una reputacion actual.";
      }
      setcookie('respuestaAlta', $agregado, time() + 3600, "/");
    }else {
      $puntajeNuevo=$_POST["puntaje1"];
      $nombreNuevo=$_POST["nombre"];
      $puntajeViejo=$_POST["puntajeRepu"];
      $nombreViejo=$_POST["nombreRepu"];
      if($puntajeNuevo != '' && $nombreNuevo != ''){
        $sql="SELECT * FROM `reputacion` WHERE `reputacion`.`Puntos` = '$puntajeNuevo'";
        $result=mysqli_query($conexion,$sql);
        $pRepetido=mysqli_num_rows($result);
        if($pRepetido == 0){
            $puntajeValido='t';
          }else{
            $puntajeValido='f';
          }
      $sql="SELECT * FROM `reputacion` WHERE `reputacion`.`Nombre` = '$nombreNuevo' AND `reputacion`.`vigente` = '0'";
      $resultado=mysqli_query($conexion, $sql);
      $cant=mysqli_num_rows($resultado);
    }elseif ($nombreNuevo==''){
      $sql="SELECT * FROM `reputacion` WHERE `reputacion`.`Puntos` = '$puntajeNuevo'";
      $result=mysqli_query($conexion,$sql);
      $pRepetido=mysqli_num_rows($result);
      if($pRepetido == 0){
          $puntajeValido='t';
        }else{
          $puntajeValido='f';
        }
        $cant=0;
        $nombreNuevo=$nombreViejo;
    }else{
      $sql="SELECT * FROM `reputacion` WHERE `reputacion`.`Nombre` = '$nombreNuevo' AND `reputacion`.`vigente`='0'";
      $resultado=mysqli_query($conexion, $sql);
      $cant=mysqli_num_rows($resultado);
      $puntajeValido='t';
      $puntajeNuevo=$puntajeViejo;
    }
    if($puntajeValido=='t' && $cant == 0){
      $sql="UPDATE `reputacion` SET `Nombre`='$nombreNuevo' , `Puntos`='$puntajeNuevo' WHERE `Nombre`= '$nombreViejo'";
      $resultado= mysqli_query($conexion, $sql);
      $modificado='t';
    }elseif ($puntajeValido=='f' && $cant>0) {
      $modificado= "El nombre ingresado ya le pertenece a una reputacion actual y el puntaje elegido da comienzo a uno de los rangos actuales";
    }elseif ($puntajeValido=='f') {
      $modificado= "El puntaje ingresado da comienzo a unos de los rangos actuales.";
    }else{
      $modificado="El nombre ingresado ya le pertenece a una reputacion actual.";
    }
  }
  setcookie('respuestaModi', $modificado, time() + 3600, "/");
  }


 ?>
