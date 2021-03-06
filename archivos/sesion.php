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
          if(estado=="Admin"){
            window.location = "administrador.php";
          }else{
            nombreDelUsuario();
            $.get("php/buscarCookie.php?nombre=pagina", function (resultado, status){
              if (resultado=="false") {
                cargarPagina("gauchadas.php");
              } else {
                cargarPagina(resultado);
              }
            });
          }
        }
      });
    });
    function modificarPublicacion(pID){
      $.post("php/guardarCookie.php?nombre=modificarGauchada&valor="+pID);
      $("#lacaja").load("modificarGauchada.php");
    }
    function verPostulantes(){
      $("#lacaja").load("postulantes.php?id="+pID);
    }
    function verDetallesPostulante(uID, pID){
     $("#lacaja").load("detallesPostulante.php?id="+uID+"&pID="+pID);
    }
    function calificarPostulante(){
      calificar(pID);
    }
    function acercaDelSitio(){
      acercaDe();
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
        <li id="pestgauchadas"><a href="sesion.php">Gauchadas</a></li>
        <li id="pestMG"><a onclick="cargarPagina('misGauchadas.php')" class="puntero">Mis gauchadas</a></li>
        <li id="pestNG"><a onclick="cargarPagina('nuevaGauchada.php')" class="puntero">Nueva gauchada</a></li>
        <li id="pestComprar"><a onclick="cargarPagina('creditos.php')" class="puntero">Comprar creditos</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span id="nombreUsuario"></span> <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li onclick="cargarPagina('perfil.php')" id="pestperfil"><a class="puntero">Perfil</a></li>
            <li onclick="acercaDelSitio()" id="acercaDe"><a class="puntero">Acerca del sitio</a></li>
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
