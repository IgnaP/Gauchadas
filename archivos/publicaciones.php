<?php
  require("conexionBD.php");
  conectarse($conexion);
  if (isset($_POST["usr"])) {
    $usrID=$_POST["usr"];
    $sql = "SELECT `Nombre`, `Ciudad`, `FechaLimite`, `Categoria`, `Descripcion`, `Imagen` FROM `publicaciones` WHERE `Activa`='1' AND `usuario`='$usrID'";
  } else {
    $sql = "SELECT `Nombre`, `Ciudad`, `FechaLimite`, `Categoria`, `Descripcion`, `Imagen` FROM `publicaciones` WHERE `Activa`='1'";
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
</head>
<body>
  <?php
    while ($row = mysqli_fetch_row($result)) {
      $ciuID=$row[1];
      $catID=$row[3];
      $sql2="SELECT `Nombre` FROM `ciudades` WHERE `ID`='$ciuID'";
      $resultado=mysqli_query($conexion,$sql2);
      $fila = mysqli_fetch_row($resultado);
      $ciu=$fila[0];
      $sql2="SELECT `Nombre` FROM `categorias` WHERE `ID`='$catID'";
      $resultado=mysqli_query($conexion,$sql2);
      $fila = mysqli_fetch_row($resultado);
      $cat=$fila[0];
  ?>
    <div class="row publicacion">
      <div class="col-md-10 col-md-offset-1">
        <h3><?php echo $row[0]; ?></h3>
        <img src="css/dog-bag.jpg" style="max-width:300px;max-height:300px;" class="center-block">
        <div class="row separar">
          <label class="label label-primary"><?php echo $ciu; ?></label>
          <label class="label label-info"><?php echo $cat; ?></label>
        </div>
        <div class="">
          <p class="text-justify"><?php echo $row[4]; ?></p>
        </div>
      </div>
    </div>
  <?php
    }
  ?>
</body>
</html>
