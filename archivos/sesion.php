<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/estilos.css">
  <link rel="icon" href="css/Logo UnaGauchada.png">
  <title>Una Gauchada</title>

  <script src="js/jquery.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/miScrips.js"></script>
  <script>
    $(document).ready(function(){
      $.get("php/estadoDeSesion.php", function (estado, status){
        if (estado=="false") {
          window.location = "index.php";
        } else {
          nombreDelUsuario();
          $.get("php/buscarCookie.php?nombre=pagina", function (resultado, status){
            if (resultado=="false") {
              cargarPagina("gauchadas.php");
            } else {
              cargarPagina(resultado);
            }
          });
        }
      });
    });
    function nombreDelUsuario(){
      $.get("php/datosDelUsuario.php?datos=devolver", function(datos){
        var jDatos= JSON.parse(datos);
        $("#nombreUsuario").text(jDatos.email);
      });
    }
    function cargarPublicacion(pID){
      $("li").removeClass("active");
      $("#lacaja").load("publicacion.php",{"ID":pID});
    }
    function verPostulantes(){
      $("#lacaja").load("postulantes.php?id="+pID);
    }
    $(document).on('click','.publicacionDiv', function(){
      var pID= $("label:first", this).text();
      cargarPublicacion(pID);
    });
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
        <li id="pestgauchadas"><a href="sesion.php">Gauchadas</a></li>
        <li id="pestMG"><a onclick="cargarPagina('misGauchadas.php')" class="puntero">Mis gauchadas</a></li>
        <li id="pestNG"><a onclick="cargarPagina('nuevaGauchada.php')" class="puntero">Nueva gauchada</a></li>
        <li id="pestComprar"><a onclick="cargarPagina('creditos.php')" class="puntero">Comprar creditos</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span id="nombreUsuario"></span> <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li onclick="" id="pestperfil"><a class="puntero">Perfil</a></li>
            <li onclick="" id="pestMiCuenta"><a class="puntero">Mi cuenta</a></li>
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
