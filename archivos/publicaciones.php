<?php
  require("php/conexionBD.php");
  conectarse($conexion);
  $fechaActual=date("Y-m-d");
  $sql="UPDATE `publicaciones` SET `Activa`='0' WHERE `FechaLimite`<'$fechaActual'";
  mysqli_query($conexion, $sql);

  if ( isset( $_POST["usr"] ) ) {
//  GAUCHADAS DE UN USUARIO (MIS GAUCHADAS)
    $usrID=$_POST["usr"];
    $sql = "SELECT * FROM publicaciones WHERE usuario=$usrID
    ORDER BY `Activa` DESC, `Fecha_publicacion` DESC";
  } else {
//  TODAS LAS GAUCHADAS ACTIVAS
    if( isset($_POST["adm"])){ // SI ES ADMIN MUESTRA TODAS
      $sql = "SELECT * FROM ((publicaciones INNER JOIN localidades ON (publicaciones.Ciudad=localidades.id)) LEFT JOIN postulantes ON (publicaciones.ID=postulantes.publicacionID))";
      $sqlWhere ="WHERE (`Activa` ='1' OR `Activa` ='0') ";
      $sqlGroup = "GROUP BY publicaciones.ID ORDER BY `Activa` DESC, `Fecha_publicacion` DESC";
    } else{
        $sql = "SELECT * FROM ((publicaciones INNER JOIN localidades ON (publicaciones.Ciudad=localidades.id)) LEFT JOIN postulantes ON (publicaciones.ID=postulantes.publicacionID))";
        $sqlWhere ="WHERE `Activa`='1'";
        $sqlGroup = "GROUP BY publicaciones.ID ORDER BY COUNT(postulantes.ID_postulacion) ASC, `Fecha_publicacion` DESC";  
    }
    if (isset($_POST["tit"])) {
      $sqlWhere=$sqlWhere." AND Nombre LIKE '%".$_POST["tit"]."%'";
    }
    if (isset($_POST["prov"])) {
      if ($_POST["prov"]!="Todas") {
        if ($_POST["ciu"]!="Todas") {
          $ciu=$_POST["ciu"];
          $sqlWhere=$sqlWhere." AND localidad='".$ciu."'";
        }else {
          $provincia=$_POST["prov"];
          $sql2="SELECT `id` FROM `provincias` WHERE `provincia`='$provincia'";
          $result=mysqli_query($conexion, $sql2);
          $row = mysqli_fetch_row($result);
          $provID=$row[0];
          $sqlWhere=$sqlWhere." AND id_provincia=".$provID;
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
        $sqlWhere=$sqlWhere." AND Categoria=".$catID;
      }
    }
    $sql=$sql." ".$sqlWhere." ".$sqlGroup;
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
    $.get("php/estadoDeSesion.php", function (estado, status){
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
    if (mysqli_num_rows($result)>0) {
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
        $debe=false;
        if ($logueado) {
          if ($usrID==$row[8]) {
            $consulta="SELECT * FROM `comentarios` WHERE `Respuesta`='' AND `Publicacion`='$pID'";
            $resultado=mysqli_query($conexion,$consulta);
            $num_filas=mysqli_num_rows($resultado);
            if ($num_filas!=0) {
              $pregPend=true;
            }
            //ver si debe una calificacion en publicación
            $sql = "SELECT `comentario` FROM `calificaciones` WHERE `ID_publicacion` = '$pID'";
            $result1 = mysqli_query($conexion,$sql);
            $cant_filas = mysqli_num_rows($result1);
            if($cant_filas > 0){
              $datos = mysqli_fetch_row($result1);
              if(is_null($datos[0])){
                $debe = true;
              }
            }
          }else {
            $consulta="SELECT * FROM `comentarios` WHERE `Respuesta`!='' AND `Publicacion`='$pID' AND `Vista`='0' AND `UsuarioID`='$usrID'";
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
  <?php         if ( $row[7]=='0' ) { ?>
                <label class="label label-danger">No vigente</label>
  <?php         } ?>
  <?php         if ($pregPend) { ?>
                <label class="label label-warning">Preguntas</label>
  <?php         } else {
                    if ($resPend) {   ?>
                <label class="label label-warning">Respuestas</label>
  <?php             }
                } ?>
  <?php         if($debe){  ?>
                <label class="label label-success">Calificación pendiente</label>
  <?php         } ?>
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
    }else {
  ?>
      <div class="jumbotron text-center">
        <b style="font-size:20px">No se encontraron gauchadas</b>
      </div>
  <?php
    }
  ?>
</body>
</html>
