<?php
  session_start();
  if (!isset($_SESSION["usuario"])) {
    header("location: http://localhost/UnaGauchada/");
  }
  if (isset($_GET['pID'])) {
    $publID=$_GET['pID'];
  } else {
    $publID=0;
  }
?>
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
  <script>
    $(document).ready(function(){
      var pID=<?php echo $publID; ?>;
      if (pID==0) {
        $("#lacaja").load("gauchadas.php");
      } else {
        $("#lacaja").load("publicacion.php",{"ID":pID});
      }
    });
    function cargarPerfil(){
      $("#lacaja").load("perfil.php");
      $("li").removeClass("active");
    }
    function miCuenta(){
      $("#lacaja").load("miCuenta.php");
      $("li").removeClass("active");
    }
    function nuevaGauchada(){
      $("#lacaja").load("nuevaGauchada.php");
      $("li").removeClass("active");
      $("#pestNG").addClass("active");
    }
    function misGauchadas(){
      $("#lacaja").load("misGauchadas.php");
      $("li").removeClass("active");
      $("#pestMG").addClass("active");
    }
    function comprar(){
    //  $("#lacaja").load(".php");
      $("li").removeClass("active");
      $("#pestComprar").addClass("active");
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
        <li class="active" id="pestgauchadas"><a href="sesion.php">Gauchadas</a></li>
        <li id="pestMG"><a onclick="misGauchadas()" class="puntero">Mis gauchadas</a></li>
        <li id="pestNG"><a onclick="nuevaGauchada()" class="puntero">Nueva gauchada</a></li>
        <li id="pestComprar"><a onclick="comprar()" class="puntero">Comprar creditos</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo "$_SESSION[usuario] "; ?> <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li onclick="cargarPerfil()" id="pestperfil"><a class="puntero">Perfil</a></li>
            <li onclick="miCuenta()" id="pestMiCuenta"><a class="puntero">Mi cuenta</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="cerrarSesion.php">Cerrar sesion <span class="glyphicon glyphicon-log-out"></span></a></li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
  <div class="container-fluid" id="lacaja">

  </div>
</body>
</html>
