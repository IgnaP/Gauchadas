<?php
  session_start();
  require("conexionBD.php");
  conectarse($conexion);
  $mail=$_SESSION['usuario'];
  $ID=$_POST["ID"];
  $sql = "SELECT * FROM `publicaciones` WHERE `ID`='$ID'";
  $result=mysqli_query($conexion, $sql);
  $row = mysqli_fetch_row($result);
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
  $sql2="SELECT `ID` FROM `usuarios` WHERE `Email`='$mail'";
  $resultado=mysqli_query($conexion,$sql2);
  $fila = mysqli_fetch_row($resultado);
  $usrID=$fila[0];
  if ($row[8]==$usrID) {
    $owner=true;
  } else {
    $owner=false;
  }

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

  });
</script>
</head>
<body>
    <div class="row">
      <div class="col-md-10 col-md-offset-1 transparente">
        <div class="row publicacion">
          <div class="col-md-7 col-md-offset-1">
            <h3><?php echo $row[1]; ?></h3>
            <img src="css/dog-bag.jpg" style="max-width:400px;max-height:400px;" class="center-block">
            <div class="row separar">
              <label class="label label-primary"><?php echo $ciu; ?></label>
              <label class="label label-info"><?php echo $cat; ?></label>
            </div>
            <div class="">
              <p class="text-justify"><?php echo $row[5]; ?></p>
            </div>
          </div>
          <div class="col-md-3 col-md-offset-1">
            <?php if ($owner) { ?>
              <button type="button" name="button" class="btn btn-default">Ver postulantes</button>
            <?php } else { ?>
              <button type="button" name="button" class="btn btn-default">Postularse</button>
            <?php } ?>
          </div>
        </div>
        <div class="row">
          <div class="col-md-10 col-md-offset-1">
            <h3>Comentarios</h3>
          </div>
        </div>
      </div>
    </div>
</body>
</html>
