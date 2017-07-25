<?php
	require("php/conexionBD.php");
  	conectarse($conexion);
  	session_start();
  	$email = $_SESSION["usuario"];
  	$consulta = "SELECT `ID` FROM `usuarios` WHERE `Email`='$email'";
  	$resultado = mysqli_query($conexion,$consulta);
  	$fila = mysqli_fetch_row($resultado);
  	$id = $fila[0];
    $sql = "SELECT * FROM `publicaciones` INNER JOIN `postulantes` ON `publicaciones`.`ID` = `postulantes`.`publicacionID` 
              WHERE (`postulantes`.`usuarioID` = '$id') ORDER BY `Activa` DESC, `Fecha_publicacion` DESC";
    $result = mysqli_query($conexion, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/estilos.css">
</head>
<script>
  $(document).ready(function(){
    $.get("php/estadoDeSesion.php", function (estado, status){
      if (estado!="false") {
        //$(".marca").addClass("publicacionDiv");
        $(".marcaBoton").removeClass("hidden");
      }
    });
  });
function cargarPublicacionDesdePerfil(pID){
  $("li").removeClass("active");
  $("#lacaja").load("publicacion.php",{"ID":pID,"desdePerfil":true});
}
</script>
<body>
	<div style="overflow-y: auto; overflow-x:hidden; height:342px">
  <?php
    if (mysqli_num_rows($result)>0) {
      while ($row = mysqli_fetch_row($result)) {
        $pID=$row[0];
        $ciuID=$row[2];
        $catID=$row[4];
        $fecha=date("d/m/Y", strtotime($row[3]));
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
        $pregPend=false;
        $resPend=false;
        $debe=false;
        $selecciono=false;
        $sql1 = "SELECT `ID_publicacion` FROM `calificaciones` WHERE `ID_publicacion` = '$pID'";
        $query = mysqli_query($conexion,$sql1);
        $cant_filas=mysqli_num_rows($query);
          if ($cant_filas>0) {
            $selecciono=true;
          }
        $consulta="SELECT * FROM `comentarios` WHERE `Respuesta`!='' AND `Publicacion`='$pID' AND `Vista`='0' AND `UsuarioID`='$id'";
        $resultado=mysqli_query($conexion,$consulta);
        $num_filas=mysqli_num_rows($resultado);
          if ($num_filas!=0) {
            $resPend=true;
          }
        if ( is_null($row[6]) ) {
          $rutaImagen="css/Logo UnaGauchada.png";
        } else {
          $rutaImagen="imagenes/".$row[6];
        }
  ?>
  <div>
    <div class="bordeAbajo">
      <div class="row">
        <div class="col-md-10 col-md-offset-1 marca">
          <label hidden><?php echo $row[0]; ?></label>
          <div class="row">
            <div class="col-md-10">
              <h3><?php echo $row[1]; ?></h3>
            </div>
            <div class="col-md-2 separar">
              <?php         
  				if($selecciono){  ?>
                <label class="label label-success">Se seleccionó postulante</label>
  <?php         } ?>
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
            </div>
          </div>
          <img src="<?php echo $rutaImagen; ?>" style="max-width:300px;max-height:300px;" class="center-block">
          <div class="row separar">
            <div class="col-md-10">
              <label class="label label-primary"><?php echo $prov; ?></label>
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
              <button type="button" name="button" class="btn btn-default detalleG" onclick="cargarPublicacionDesdePerfil(<?php echo "'".$row[0]."'" ?>)">Ver gauchada</button>
            </div>
          </div>
        </div>
      </div>
    </div>
   </div>
  <?php
      }
    }else {
  ?>
    <div class="separar text-center" style="height: 20px"><strong> No se ha postulado a ninguna gauchada </strong></div>
  <?php
    }
  ?>
  </div>
</body>
</html>