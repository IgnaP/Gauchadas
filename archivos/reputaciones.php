<?php
require("php/conexionBD.php");
conectarse($conexion);
$sql="SELECT * FROM `reputacion` WHERE `vigente`=0 ORDER BY `Puntos`";
$resultado=mysqli_query($conexion,$sql);
if(!$resultado){
  echo 'No se pudo realizar la consulta:'.mysql_error();
};
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/estilos.css">
  <link href="css/jquery-confirm.min.css" rel="stylesheet">
  <link href="css/jquery-confirm.css" rel="stylesheet">
  <script src="js/miScrips.js"></script>
  <script src="js/jquery.js"></script>
  <script src="js/jquery-confirm.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</head>
<script>
function cambiarAlertaRepu(tf, txt){
  cargarPagina("reputaciones.php");
  cambiarAlerta(tf,txt);

}
function confirmarEliminacion(nombreRepu){
  var funcion='eliminar';
  $.confirm({
    title: 'Eliminacion de reputaciones',
    content: 'Usted eliminara la reputacion '+nombreRepu,
    buttons: {
        Aceptar: function () {
              $.get("abm_reputaciones.php",{nombreRepu,funcion}, function(datos){
                var datosJ= JSON.parse(datos);
                if(datosJ.borrado=='t'){
                  cambiarAlertaRepu(true, "Se ha eliminado la reputacion correctamente");
                } else {
                    cambiarAlerta(false, "No se ha podido realizar la eliminacion debido a que la reputacion seleccionada no se encuentra en los extremos");
              }
            });
  },
        cancelar: function () {

      },
    },
  });
}

function confirmarModificacion(nombreRepu){
  var funcion='modificar';
  $.confirm({
    title: 'Modificacion de la reputacion '+ nombreRepu,
    content: '' +
    '<form action="calificar.php" class="formulario" method="post">' +
    '<div class="form-group">' +
    '<label>Nuevo nombre:</label></br>' +
    '<textarea name="nombre" class="nombre" rows = "1" cols ="30" maxlength="50">' +
    '</textarea>' +
    '</div>' +
    '<div class="form-group">' +
    '<label>Nuevo rango de puntaje:</label></br>' +
    '<label> Desde: &nbsp;</label>'+
    '<textarea name="puntaje1" class="puntaje1" rows = "1" cols ="10" maxlength="10">'+
    '</textarea></br>'+
    '<label> hasta: &nbsp; </label>'+
    '<textarea name="puntaje2" class="puntaje2" rows = "1" cols ="10" maxlength="10">' +
    '</textarea>' +
    '</div>'+
    '</form>',
    buttons: {
      fromSubmit: {
        text: 'Modificar',
        btnClass: 'btn-blue',
        action: function() {
          var nombre=this.$content.find('.nombre').val();
          var puntaje1= this.$content.find('.puntaje1').val();
          var puntaje2= this.$content.find('.puntaje2').val();
          if(!puntaje1 && !nombre && !puntaje2){
            $.alert('Debe realizar alguna modificacion.');
            return false;
          }
      }
    },
    cancelar: function(){}
  },
});
}

function creacion(){
  var funcion='crear';
  $.confirm({
    title: 'Crear una nueva reputacion',
    content: '' +
    '<form action="calificar.php" class="formulario" method="post">' +
    '<div class="form-group">' +
    '<label>Nombre:</label></br>' +
    '<textarea name="nombre" class="nombre" rows = "1" cols ="30" maxlength="50">' +
    '</textarea>' +
    '</div>' +
    '<div class="form-group">' +
    '<label> A partir de: &nbsp;</label>'+
    '<textarea name="puntaje1" class="puntaje1" rows = "1" cols ="10" maxlength="10">'+
    '</textarea></br>'+
    '</div>'+
    '</form>',
    buttons: {
      fromSubmit: {
        text: 'Crear',
        btnClass: 'btn-blue',
        action: function() {
          var nombre=this.$content.find('.nombre').val();
          var puntaje1= this.$content.find('.puntaje1').val();
          if(!puntaje1 | !nombre){
            $.alert('Debe completar todos los campos.');
            return false;
          } else{
            $.get("abm_reputaciones.php",{nombre,puntaje1,funcion}, function(datos){
              var datosJ= JSON.parse(datos);
                if (datosJ.Existe > 0) {
                  cambiarAlertaRepu(false, "El nombre ingresado ya pertenece a una reputacion actual.");
                }else if(datosJ.p1Valido=='f') {
                  cambiarAlerta(false, "El puntaje ingresado se encuentra en medio de las reputaciones existentes.");
                }else{
                  cambiarAlerta(true, "Se ha agregado la reputacion exitosamente.");
                }
  });
          }
      }
    },
    cancelar: function(){},
  },
});
}

</script>
<body>
  <div class="row">
<div class="container-fluid">
    <div>
      <h2 class="text-center">Reputaciones</h2>
    </div>
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
    <div class="alert col-md-10 col-md-offset-1 hidden text-center" id="alertaForm">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong id="alertaTxt"></strong>
      </div>
  <table class="table fondoBlanco">
    <tr class="info">
      <th class="text-center">Reputacion</th>
      <th class="text-center">Puntaje</th>
      <th class="text-center" colspan="4"> Opciones </th>
    </tr>
   <?php
      while($datos=mysqli_fetch_row($resultado)){?>
      <tr class= "text-center" >
        <td> <?php echo $datos[1]; ?> </td>
        <td> <?php
                  if($datos[2] < 0){
                    echo 'Menor a ',$datos[2];}
                    else {
                      echo '+', $datos[2];
                    }?>  </td>
                    <td class="text-center" ><button type="button" class="btn btn-default" onclick="confirmarModificacion(<?php echo "'".$datos[1]."'"?>)"> Modificar</td>
                    <td class="text-center " ><button type="button" class="btn btn-default" onclick="confirmarEliminacion(<?php echo "'".$datos[1]."'"?>)">  Eliminar </td>
                  </tr>
<?php } ?>
      <tr>
    <td class= "text-center" colspan="4"><button type="button" class="btn btn-primary" onclick="creacion()" >Crear una reputacion</td>
  </tr>
</table>
</div>
</div>
</div>
</div>
</body>
</html>
