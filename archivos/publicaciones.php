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
      window.location.href="sesion.php?pID=" + pID;
    });
  });
</script>
</head>
<body>
  <?php
    while ($row = mysqli_fetch_row($result)) {
      $ciuID=$row[2];
      $catID=$row[4];
      $sql2="SELECT `Nombre` FROM `ciudades` WHERE `ID`='$ciuID'";
      $resultado=mysqli_query($conexion,$sql2);
      $fila = mysqli_fetch_row($resultado);
      $ciu=$fila[0];
      $sql2="SELECT `Nombre` FROM `categorias` WHERE `ID`='$catID'";
      $resultado=mysqli_query($conexion,$sql2);
      $fila = mysqli_fetch_row($resultado);
      $cat=$fila[0];
  ?>
    <div class="publicacion">
      <div class="row">
        <div class="col-md-10 col-md-offset-1 publicacionDiv">
          <label hidden><?php echo $row[0]; ?></label>
          <h3><?php echo $row[1]; ?></h3>
          <img src="css/dog-bag.jpg" style="max-width:300px;max-height:300px;" class="center-block">
          <div class="row separar">
            <label class="label label-primary"><?php echo $ciu; ?></label>
            <label class="label label-info"><?php echo $cat; ?></label>
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
