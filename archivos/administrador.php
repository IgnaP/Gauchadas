<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/jquery-confirm.min.css" rel="stylesheet">
  <link href="css/jquery-confirm.css" rel="stylesheet">
  <link rel="stylesheet" href="css/estilos.css">
  <link rel="icon" href="css/Logo UnaGauchada.png">
  <title>Una Gauchada</title>

  <script src="js/jquery.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery-confirm.min.js"></script>
  <script src="js/miScrips.js"></script>
  <script>
  $(document).ready(function(){
    $.get("php/estadoDeSesion.php", function (estado, status){
      if (estado=="false") {
        window.location = "index.php";
      } else {
              cargarPagina('gauchadas.php');
            }
    });
  })

  function modificarCredito(precioActual){
    $.confirm({
      title: 'Modificacion de tarifa de credito',
      content: '' +
      '<form action="calificar.php" class="formulario" method="post">' +
      '<div class="form-group">' +
      '<label>Precio actual: $'+ precioActual +' c/u</label></br>' +
      '</div>' +
      '<div class="form-group">' +
      '<label> Precio nuevo: &nbsp;</label>'+
      '<input type="number" name="precio" id="precio" class="precio" maxlength="10" >'+
      '</br>'+
      '</div>'+
      '</form>',
      buttons: {
        fromSubmit: {
          text: 'Modificar',
          btnClass: 'btn-blue',
          action: function() {
            var precio= this.$content.find('.precio').val();
            if(!precio){
              $.alert('Debe completar el campo del precio nuevo.');
              return false;
            } else{
              $.post("modificacionCredito.php",{ precio: precio });
              $.confirm({
                title: ' ',
                content: 'Modificacion realizada correctamente.' ,
               buttons: {
                 Aceptar: function () {

                  }
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
</head>
<body>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand">
          <img src="css/Logo UnaGauchada.png" alt="Brand" style="height:50px">
        </a>
      </div>
      <ul class="nav navbar-nav">
        <li class="borde"><strong class="navbar-text tituloDeLaNavbar">Una Gauchada</strong></li>
        <li id="pestgauchadas"><a href="administrador.php">Gauchadas</a></li>
        <li id="pestComprar"><a onclick="cargarPagina('categorias.php')" class="puntero">Categorias</a></li>
        <li id="pestComprar"><a onclick="cargarPagina('reputaciones.php')" class="puntero">Reputaciones</a></li>
        <li id="pestNG"><a onclick="cargarPagina('ganancias.php')" class="puntero">Informe ganancias</a></li>
        <li id="pestComprar"><a onclick="cargarPagina('usuarios.php')" class="puntero">Usuarios</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span id="nombreUsuario"></span> Admin <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li onclick="" id="pestperfil"><a class="puntero">Acerca del sitio</a></li>
            <?php
             //Busco el precio del credito vigente.
             require("php/conexionBD.php");
             conectarse($conexion);
            $consulta= "SELECT * FROM `credito` WHERE `credito`.`Vigente`='0'";
            $resultado= mysqli_query($conexion,$consulta);
            $precioActual=mysqli_fetch_row($resultado); ?>
            <li onclick="modificarCredito(<?php echo "'".$precioActual[1]."'"?>)" id="modiCredito"><a class="puntero">Modificar precio de credito</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="php/cerrarSesion.php">Cerrar sesion <span class="glyphicon glyphicon-log-out"></span></a></li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
  <div class="container-fluid" id="lacaja">

  </div>

</body>
</html>
