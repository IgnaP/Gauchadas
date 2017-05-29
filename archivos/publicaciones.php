<?php
  require("conexionBD.php");
  conectarse($conexion);
  $sql = "SELECT * FROM ((publicaciones INNER JOIN localidades ON (publicaciones.Ciudad=localidades.id)) LEFT JOIN postulantes ON (publicaciones.ID=postulantes.publicacionID)) WHERE ";
  $sql1 = "GROUP BY publicaciones.ID ORDER BY COUNT(postulantes.ID_postulacion) ASC";
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
  if (isset($_POST["prov"])) {
    if ($_POST["prov"]!="Todas") {
      if ($_POST["ciu"]!="Todas") {
        $ciu=$_POST["ciu"];
        $sql=$sql." AND localidad='".$ciu."'";
      }else {
        $provincia=$_POST["prov"];
        $sql2="SELECT `id` FROM `provincias` WHERE `provincia`='$provincia'";
        $result=mysqli_query($conexion, $sql2);
        $row = mysqli_fetch_row($result);
        $provID=$row[0];
        $sql=$sql." AND id_provincia=".$provID;
      }
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
  $sql=$sql." ".$sql1;
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
    $(document).on('click','.publicacionDiv', function(){
      var pID= $("label:first", this).text();
      cargarPublicacion(pID);
    });
    $.get("estadoDeSesion.php", function (estado, status){
      if (estado=="true") {
        $(".marca").addClass("publicacionDiv");
        $(".marcaBoton").removeClass("hidden");
      }
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
      $sql2="SELECT `localidad` FROM `localidades` WHERE `id`='$ciuID'";
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
      if ( is_null($row[6]) ) {
        $rutaImagen="css/Logo UnaGauchada.png";
      } else {
        $rutaImagen="imagenes/".$row[6];
      }
  ?>
    <div class="bordeAbajo">
      <div class="row">
        <div class="col-md-10 col-md-offset-1 marca">
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
          <img src="<?php echo $rutaImagen; ?>" style="max-width:300px;max-height:300px;" class="center-block">
          <div class="row separar">
            <div class="col-md-10">
              <label class="label label-primary"><?php echo $ciu; ?></label>
              <label class="label label-info"><?php echo $cat; ?></label>
            </div>
            <div class="col-md-2">
              <span><?php echo $fecha; ?></span>
            </div>
          </div>
          <div class="row">
            <p class="text-justify"><?php echo $row[5]; ?></p>
          </div>
          <div class="col-md-2 col-md-offset-5 hidden marcaBoton">
            <div class="form-group">
              <button type="button" name="button" class="btn btn-default">Ver gauchada</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php
    }
  ?>
</body>
</html>
