<?php
  require("conexionBD.php");
  conectarse($conexion);
  $sql = "SELECT * FROM `publicaciones` WHERE ";
  if (isset($_POST["activa"])) {
    if ($_POST["activa"]=="false") {
      $sql=$sql."`Activa`='0'";
    } else {
      $sql=$sql."`Activa`='1'";
    }
  }else {
    $sql=$sql."`Activa`='1'";
  }
  if (isset($_POST["usr"])) {
    $usrID=$_POST["usr"];
    $sql=$sql." AND usuario=".$usrID;
  }
  if (isset($_POST["tit"])) {
    $sql=$sql." AND Nombre LIKE '%".$_POST["tit"]."%'";
  }
  if (isset($_POST["ciu"])) {
    if ($_POST["ciu"]!="Todas") {
      $ciu=$_POST["ciu"];
      $sql2="SELECT `ID` FROM `ciudades` WHERE `Nombre`='$ciu'";
      $result=mysqli_query($conexion, $sql2);
      $row = mysqli_fetch_row($result);
      $ciuID=$row[0];
      $sql=$sql." AND Ciudad=".$ciuID;
    }
  }
  if (isset($_POST["cat"])) {
    if ($_POST["cat"]!="Todas") {
      $cat=$_POST["cat"];
      $sql2="SELECT `ID` FROM `categorias` WHERE `Nombre`='$cat'";
      $result=mysqli_query($conexion, $sql2);
      $row = mysqli_fetch_row($result);
      $catID=$row[0];
      $sql=$sql." AND Categoria=".$catID;
    }
  }
  $result=mysqli_query($conexion, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/estilos.css">
<script>
  $(document).ready(function(){
    $(".publicacionDiv").click(function(){
      var pID= $("label:first", this).text();
      cargarPublicacion(pID);
    });
  });
</script>
</head>
<body>
  <?php
    session_start();
    $logueado=false;
    if ( isset($_SESSION['usuario']) ) {
      $logueado=true;
      $mail=$_SESSION['usuario'];
      $sql2="SELECT `ID` FROM `usuarios` WHERE `Email`='$mail'";
      $resultado=mysqli_query($conexion,$sql2);
      $fila = mysqli_fetch_row($resultado);
      $usrID=$fila[0];
    }
    while ($row = mysqli_fetch_row($result)) {
      $pID=$row[0];
      $ciuID=$row[2];
      $catID=$row[4];
      $fecha=date("d/m/Y", strtotime($row[3]));
      $sql2="SELECT `Nombre` FROM `ciudades` WHERE `ID`='$ciuID'";
      $resultado=mysqli_query($conexion,$sql2);
      $fila = mysqli_fetch_row($resultado);
      $ciu=$fila[0];
      $sql2="SELECT `Nombre` FROM `categorias` WHERE `ID`='$catID'";
      $resultado=mysqli_query($conexion,$sql2);
      $fila = mysqli_fetch_row($resultado);
      $cat=$fila[0];
      $pregPend=false;
      $resPend=false;
      if ($logueado) {
        if ($usrID==$row[8]) {
          $consulta="SELECT * FROM `comentarios` WHERE `Respuesta`='' AND `Publicacion`='$pID'";
          $resultado=mysqli_query($conexion,$consulta);
          $num_filas=mysqli_num_rows($resultado);
          if ($num_filas!=0) {
            $pregPend=true;
          }
        }else {
          $consulta="SELECT * FROM `comentarios` WHERE `Respuesta`!='' AND `Publicacion`='$pID' AND `Vista`='0'";
          $resultado=mysqli_query($conexion,$consulta);
          $num_filas=mysqli_num_rows($resultado);
          if ($num_filas!=0) {
            $resPend=true;
          }
        }
      }
  ?>
    <div class="publicacion">
      <div class="row">
        <div class="col-md-10 col-md-offset-1 publicacionDiv">
          <label hidden><?php echo $row[0]; ?></label>
          <div class="row">
            <div class="col-md-10">
              <h3><?php echo $row[1]; ?></h3>
            </div>
            <div class="col-md-2 separar">
              <?php if ($pregPend) { ?>
                <label class="label label-warning">Preguntas</label>
            <?php  } else {if ($resPend) {   ?>
                <label class="label label-warning">Respuestas</label>
            <?php } } ?>
            </div>
          </div>
          <img src="css/dog-bag.jpg" style="max-width:300px;max-height:300px;" class="center-block">
          <div class="row separar">
            <div class="col-md-10">
              <label class="label label-primary"><?php echo $ciu; ?></label>
              <label class="label label-info"><?php echo $cat; ?></label>
            </div>
            <div class="col-md-2">
              <span><?php echo $fecha; ?></span>
            </div>
          </div>
          <div class="">
            <p class="text-justify"><?php echo $row[5]; ?></p>
          </div>
        </div>
      </div>
    </div>
  <?php
    }
  ?>
</body>
</html>
