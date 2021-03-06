<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/estilos.css">
  <link href="css/jquery-confirm.min.css" rel="stylesheet">
  <link href="css/jquery-confirm.css" rel="stylesheet">
  <link rel="icon" href="css/Logo UnaGauchada.png">
  <title>Una Gauchada</title>

  <script src="js/jquery.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery-confirm.min.js"></script>
  <script src="js/miScrips.js"></script>
  <script>
    $.get("php/estadoDeSesion.php", function (estado, status){
      if (estado=="true") {
        $.get("../php/datosDelUsuario.php?datos=devolver", function(datos){
          var jDatos= JSON.parse(datos);
          if(jDatos.admin == 1){
            window.location = "administrador.php";
          } else {
            window.location = "sesion.php";
          }
        });
      } else {
        $.get("php/buscarCookie.php?nombre=pagina", function (resultado, status){
          if (resultado=="false") {
            cargarPagina("gauchadas.php");
          } else {
            cargarPagina(resultado);
          }
        });
      }
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
        <li id="pestgauchadas"><a href="index.php">Gauchadas</a></li>

      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li id="pestIS"><a onclick="cargarPagina('iniciarSesion.php')" class="puntero">Iniciar sesion</a></li>
        <li id="pestReg"><a onclick="cargarPagina('registrarse.php')" class="puntero">Registrarse</a></li>
        <li id="acercaDe"><a onclick="acercaDe()" class="puntero">Acerca del sitio</a></li>
      </ul>
    </div>
  </nav>
  <div class="conteiner-fluid" id="lacaja">

  </div>
</body>
</html>
