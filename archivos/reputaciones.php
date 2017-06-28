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
  $.get("php/buscarCookie.php?nombre=respuestaEli", function (resultado, status){
    if (resultado!="false") {
      if (resultado == 't') {
        cambiarAlerta(true, "La reputacion se ha borrado correctamente.");
      } else {
        cambiarAlerta(false, resultado);
      }
    }
  });
  $.get("php/buscarCookie.php?nombre=respuestaAlta", function (resultado, status){
    if (resultado!="false") {
      if (resultado == 't') {
        cambiarAlerta(true, "La reputacion se ha creado correctamente.");
      } else {
        cambiarAlerta(false, resultado);
      }
    }
  });
  $.get("php/buscarCookie.php?nombre=respuestaModi", function (resultado, status){
    if (resultado!="false") {
      if (resultado == 't') {
        cambiarAlerta(true, "La reputacion se ha modificado correctamente.");
      } else {
        cambiarAlerta(false, resultado);
      }
    }
  });
})

function confirmarEliminacion(nombreRepu){
  $.confirm({
    title: 'Eliminacion de reputaciones',
    content: 'Usted eliminara la reputacion '+nombreRepu,
    buttons: {
        Aceptar: function () {
            $.post("abm_reputaciones.php" , {nombreRepu: nombreRepu , funcion: 'eliminar'},function functionName() {
                cargarPagina('reputaciones.php');
            });

  },
        cancelar: function () {    },
    }
  });
}

function confirmarModificacion(nombreRepu,puntajeRepu){
  $.confirm({
    title: 'Modificacion de la reputacion '+ nombreRepu,
    content: '' +
    '<form action="calificar.php" class="formulario" method="post">' +
    '<div class="form-group">' +
    '<label>Nuevo nombre:</label></br>' +
    '<input type= "text" name="nombre" class="nombre" id="nombre" required autofocus pattern="[a-zA-Záéíóú ]{3,20}" title="De 3 a 30 letras o numeros" placeholder=' + nombreRepu + '>'+
    '</div>' +
    '<div class="form-group">' +
    '<label> A partir de: &nbsp;</label>'+
    '<input type="number" name="puntaje1" class="puntaje1" id="puntaje1" maxlength="10" placeholder='+ puntajeRepu +'>'+
    '</br>'+
    '</div>'+
    '</form>',
    buttons: {
      fromSubmit: {
        text: 'Modificar',
        btnClass: 'btn-blue',
        action: function() {
          var nombre=this.$content.find('.nombre').val();
          var puntaje1= this.$content.find('.puntaje1').val();
          if(!puntaje1 && !nombre){
            $.alert('Debe realizar alguna modificacion.');
            return false;
          }else{
            $.post("abm_reputaciones.php",{nombre:nombre , puntaje1: puntaje1 , funcion: 'modificar',nombreRepu: nombreRepu, puntajeRepu: puntajeRepu},function functionName() {
              cargarPagina('reputaciones.php');
          });
        }
    }
      },
    cancelar: function(){    },

  }
});
}

function creacion(){
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
          var nombreRepu=this.$content.find('.nombre').val();
          var puntaje= this.$content.find('.puntaje1').val();
          if(!puntaje | !nombreRepu){
            $.alert('Debe completar todos los campos.');
            return false;
          } else{
            $.post("abm_reputaciones.php",{nombre:nombreRepu , puntaje1: puntaje , funcion: 'crear'},function functionName() {
                cargarPagina('reputaciones.php');
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
   require("php/conexionBD.php");
   conectarse($conexion);
   $sql="SELECT * FROM `reputacion` WHERE `vigente`= 0 ORDER BY `Puntos`";
   $resultado=mysqli_query($conexion,$sql);
      while($datos=mysqli_fetch_row($resultado)){?>
      <tr class= "text-center" >
        <td> <?php echo $datos[1]; ?> </td>
        <td> <?php
                  if($datos[2] < 0){
                    echo 'Menor a ',$datos[2];}
                    else {
                      echo '+', $datos[2];
                    }?>  </td>
                    <td class="text-center" ><button type="button" class="btn btn-default" onclick="confirmarModificacion(<?php echo "'".$datos[1]."'"?>,<?php echo "'".$datos[2]."'"?>)"> Modificar</td>
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
