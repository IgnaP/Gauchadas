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
  $.get("php/buscarCookie.php?nombre=categoriaEli", function (resultado, status){
    if (resultado!="false") {
        cambiarAlerta(true, "La categoria se ha borrado correctamente.");
  }
  });
  $.get("php/buscarCookie.php?nombre=categoriaAlta", function (resultado, status){
    if (resultado!="false") {
      if (resultado == 't') {
        cambiarAlerta(true, "La categoria se ha creado correctamente.");
      } else {
        cambiarAlerta(false, resultado);
      }
    }
  });
  $.get("php/buscarCookie.php?nombre=categoriaModi", function (resultado, status){
    if (resultado!="false") {
      if (resultado == 't') {
        cambiarAlerta(true, "La reputacion se ha modificado correctamente.");
      } else {
        cambiarAlerta(false, resultado);
      }
    }
  });
})

function confirmarEliminacion(nombreCategoria){
  $.confirm({
    title: 'Eliminacion de categoria',
    content: 'Usted eliminara la categoria '+nombreCategoria,
    buttons: {
        Aceptar: function () {
            $.post("abm_categorias.php" , {nombreCategoria: nombreCategoria , funcion: 'eliminar'},function functionName() {
                cargarPagina('categorias.php');
            });

  },
        cancelar: function () {    },
    }
  });
}

function confirmarModificacion(nombreCategoria){
  $.confirm({
    title: 'Modificacion de la categoria '+ nombreCategoria,
    content: '' +
    '<form action="calificar.php" class="formulario" method="post">' +
    '<div class="form-group">' +
    '<label>Nuevo nombre:</label></br>' +
    '<input type= "text" name="nombre" class="nombre" id="nombre" required autofocus pattern="[a-zA-Záéíóú ]{3,20}" title="De 3 a 30 letras o numeros" placeholder=' + nombreCategoria + '>'+
    '</div>' +
    '</form>',
    buttons: {
      fromSubmit: {
        text: 'Modificar',
        btnClass: 'btn-blue',
        action: function() {
          var nombre=this.$content.find('.nombre').val();
          if(!nombre){
            $.alert('Debe realizar alguna modificacion.');
            return false;
          }else{
            $.post("abm_categorias.php",{nombre:nombre , nombreCategoria:nombreCategoria , funcion: 'modificar'},function functionName() {
              cargarPagina('categorias.php');
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
    title: 'Crear una nueva categoria',
    content: '' +
    '<form action="calificar.php" class="formulario" method="post">' +
    '<div class="form-group">' +
    '<label>Nombre:</label></br>' +
    '<textarea name="nombre" class="nombre" rows = "1" cols ="30" maxlength="50">' +
    '</textarea>' +
    '</div>' +
    '</form>',
    buttons: {
      fromSubmit: {
        text: 'Crear',
        btnClass: 'btn-blue',
        action: function() {
          var nombreCategoria=this.$content.find('.nombre').val();
          if(!nombreCategoria){
            $.alert('Debe completar el campo.');
            return false;
          } else{
            $.post("abm_categorias.php",{nombre:nombreCategoria , funcion: 'crear'},function functionName() {
                cargarPagina('categorias.php');
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
<div class="transparente col-md-6 col-md-offset-3">
    <div>
      <h2 class="text-center">Categorias</h2>
    </div>
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
    <div class="alert col-md-10 col-md-offset-1 hidden text-center" id="alertaForm">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong id="alertaTxt"></strong>
      </div>
  <table class="table fondoBlanco">
    <tr class="info">
      <th class="text-center">Categoria</th>
      <th class="text-center" colspan="4"> Opciones </th>
    </tr>
   <?php
   require("php/conexionBD.php");
   conectarse($conexion);
   $sql="SELECT * FROM `categorias` WHERE `vigente`= 1 ";
   $resultado=mysqli_query($conexion,$sql);
      while($datos=mysqli_fetch_row($resultado)){?>
      <tr class= "text-center" >
        <td> <?php echo $datos[1]; ?> </td>
        <td class="text-center" ><button type="button" class="btn btn-default" onclick="confirmarModificacion(<?php echo "'".$datos[1]."'"?>)"> Modificar</td>
        <td class="text-center " ><button type="button" class="btn btn-default" onclick="confirmarEliminacion(<?php echo "'".$datos[1]."'"?>)">  Eliminar </td>
        </tr>
<?php } ?>
      <tr>
    <td class= "text-center" colspan="4"><button type="button" class="btn btn-primary" onclick="creacion()" >Crear una categoria</td>
  </tr>
</table>
</div>
</div>
</div>
</div>
</body>
</html>
