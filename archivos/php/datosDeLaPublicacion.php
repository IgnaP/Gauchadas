<?php
  require("conexionBD.php");
  conectarse($conexion);
  $ID=$_GET["ID"];
  $sql = "SELECT * FROM `publicaciones` WHERE `ID`='$ID'";
  $result=mysqli_query($conexion, $sql);
  $row = mysqli_fetch_row($result);
  $ciuID=$row[2];
  $fechaOriginal=$row[3];
  $catID=$row[4];
  $imagen=$row[6];
  $dueñoID=$row[8];
  $activa = $row[7];
  $fecha=date("d/m/Y", strtotime($fechaOriginal) );
  $sql2="SELECT * FROM `localidades` WHERE `id`='$ciuID'";
  $resultado=mysqli_query($conexion,$sql2);
  $fila = mysqli_fetch_row($resultado);
  $ciu=$fila[2];
  $provID=$fila[1];
  $sql2="SELECT `provincia` FROM `provincias` WHERE `id`='$provID'";
  $resultado=mysqli_query($conexion,$sql2);
  $fila = mysqli_fetch_row($resultado);
  $prov=$fila[0];
  $sql2="SELECT `Nombre` FROM `categorias` WHERE `ID`='$catID'";
  $resultado=mysqli_query($conexion,$sql2);
  $fila = mysqli_fetch_row($resultado);
  $cat=$fila[0];
  $sql2="SELECT `Email` FROM `usuarios` WHERE `ID`='$dueñoID'";
  $resultado=mysqli_query($conexion,$sql2);
  $fila = mysqli_fetch_row($resultado);
  $dueñoUsr=$fila[0];
  //ver si la publicacion tiene postulantes
  $sql4 = "SELECT `usuarioID` FROM `postulantes` WHERE publicacionID = '$ID'";
  $result4 = mysqli_query($conexion, $sql4);
  $cantFilas= mysqli_num_rows($result4);
  if($cantFilas >0){
    $tienePostulantes = true;
  } else {
    $tienePostulantes = false;
  }

  $postulado=false;
  session_start();
  $owner=false;
  $logueado=false;
  if ( isset($_SESSION['usuario']) ) {
    $logueado=true;
    $mail=$_SESSION['usuario'];
    $sql2="SELECT `ID` FROM `usuarios` WHERE `Email`='$mail'";
    $resultado=mysqli_query($conexion,$sql2);
    $fila = mysqli_fetch_row($resultado);
    $usrID=$fila[0];
    if ($dueñoUsr==$mail) {
      $owner=true;
      $sql2="UPDATE `publicaciones` SET `Vista`='1' WHERE `usuario`='$usrID'";
    } else {
      $sql2="UPDATE `comentarios` SET `Vista`='1' WHERE `UsuarioID`='$usrID'";

      $sql3="SELECT `usuarioID` FROM `postulantes` WHERE `publicacionID`='$ID' AND `usuarioID`='$usrID'";
      $resultado=mysqli_query($conexion,$sql3);
      if (mysqli_num_rows($resultado)>0) {
        $postulado=true;
      }
    }
    mysqli_query($conexion,$sql2);
  }

  $arreglo = array('tit' => "$row[1]", 'cat' => "$cat", 'ciu' => "$ciu", 'desc' => "$row[5]",
   'owner' => "$dueñoUsr", 'usr' => "$mail", 'logueado' => "$logueado", 'fecha' => "$fecha",
    'postulado' => "$postulado", 'imagen' => "$imagen", 'fechaOriginal' => "$fechaOriginal", 'prov' => "$prov", 'activa' => "$activa", 'tienePostulantes' => "$tienePostulantes");

  $jDatos = json_encode($arreglo);
  echo $jDatos;
?>
