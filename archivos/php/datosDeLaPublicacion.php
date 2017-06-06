<?php
  require("conexionBD.php");
  conectarse($conexion);
  $ID=$_GET["ID"];
  $sql = "SELECT * FROM `publicaciones` WHERE `ID`='$ID'";
  $result=mysqli_query($conexion, $sql);
  $row = mysqli_fetch_row($result);
  $ciuID=$row[2];
  $catID=$row[4];
  $imagen=$row[6];
  $dueñoID=$row[8];
  $fecha=date("d/m/Y", strtotime($row[3]));
  $sql2="SELECT `localidad` FROM `localidades` WHERE `id`='$ciuID'";
  $resultado=mysqli_query($conexion,$sql2);
  $fila = mysqli_fetch_row($resultado);
  $ciu=$fila[0];
  $sql2="SELECT `Nombre` FROM `categorias` WHERE `ID`='$catID'";
  $resultado=mysqli_query($conexion,$sql2);
  $fila = mysqli_fetch_row($resultado);
  $cat=$fila[0];
  $sql2="SELECT `Email` FROM `usuarios` WHERE `ID`='$dueñoID'";
  $resultado=mysqli_query($conexion,$sql2);
  $fila = mysqli_fetch_row($resultado);
  $dueñoUsr=$fila[0];

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
    'postulado' => "$postulado", 'imagen' => "$imagen");

  $jDatos = json_encode($arreglo);
  echo $jDatos;
?>
