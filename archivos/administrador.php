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
        <li id="pestgauchadas"><a href="administrador.php">Gauchadas</a></li>
        <!--<li id="pestMG"><a onclick="cargarPagina('misGauchadas.php')" class="puntero">Informe ganancias</a></li>-->
        <li id="pestNG"><a onclick="cargarPagina('ganancias.php')" class="puntero">Informe ganancias</a></li>
        <li id="pestComprar"><a onclick="cargarPagina('categorias.php')" class="puntero">Categorias</a></li>
        <li id="pestComprar"><a onclick="cargarPagina('reputaciones.php')" class="puntero">Reputaciones</a></li>
        <li id="pestComprar"><a onclick="cargarPagina('usuarios.php')" class="puntero">Usuarios</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span id="nombreUsuario"></span> Admin <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <!--<li onclick="" id="pestperfil"><a class="puntero">Perfil</a></li>-->
            <li onclick="" id="pestMiCuenta"><a class="puntero">Modificar precio de credito</a></li>
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
