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
      marcarPestaña("#pestgauchadas");
      $.get("php/datosDelUsuario.php?datos=devolver", function(datos){
        var jDatos= JSON.parse(datos);
      	$("#publicaciones").load("publicaciones.php",{"adm": true});
     	$("#filtrarForm").submit(function(){
        $("#lacaja").load("publicaciones.php", {"adm": true, "tit": $("#titulo").val(), "cat": $("#categorias").val(), "prov": $("#provincias").val(), "ciu": $("#ciudades").val()});
        return false;
      });
  	  });
      cargarProvincias('Todas');
      cargarCategorias('Todas');
      $.get("php/estadoDeSesion.php", function (estado, status){
        if (estado=="false") {
          window.location = "index.php";
        } else {
          nombreDelUsuario();
         	$.get("php/buscarCookie.php?nombre=pagina", function (resultado, status){
            if (resultado=="false") {
              cargarPagina("administrador.php");
            } else {
              cargarPagina(resultado);
            }
          });
        }
      });
    });
    $(document).on('click','.publicacionDiv', function(){
     var pID= $("label:first", this).text();
     cargarPublicacion(pID);
    });
    function cargarPublicacion(pID){
     $("li").removeClass("active");
     $("#lacaja").load("publicacion.php",{"ID":pID});
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
        <!--<li id="pestMG"><a onclick="cargarPagina('misGauchadas.php')" class="puntero">Informe ganancias</a></li>
        <li id="pestNG"><a onclick="cargarPagina('nuevaGauchada.php')" class="puntero">Informe usuarios</a></li>
        <li id="pestComprar"><a onclick="cargarPagina('creditos.php')" class="puntero">Categorias</a></li> -->
        <li id="pestComprar"><a onclick="cargarPagina('reputaciones.php')" class="puntero">Reputaciones</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span id="nombreUsuario"></span> Admin <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <!--<li onclick="" id="pestperfil"><a class="puntero">Perfil</a></li>
            <li onclick="" id="pestMiCuenta"><a class="puntero">Mi cuenta</a></li>-->
            <li role="separator" class="divider"></li>
            <li><a href="php/cerrarSesion.php">Cerrar sesion <span class="glyphicon glyphicon-log-out"></span></a></li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
  <div class="row">
    <div class="col-md-2 filtros alturaminima" id="lado">
      <div class="row">
        <div class="col-md-10 col-md-offset-1">
          <h3>Filtros</h3>
          <form class="" action="" method="post" id="filtrarForm">
            <div class="separar">
              <label for="titulo">Titulo</label>
              <input type="text" class="form-control" placeholder="Buscar" id="titulo">
            </div>
            <label for="ciudades">Provincias</label>
            <select class="form-control" name="provincias" id="provincias" onchange="localidadesFuncion('Todas')"></select>
            <label for="ciudades">Ciudades</label>
            <select class="form-control" name="ciudades" id="ciudades" disabled>
              <option value="Todas">Todas</option>
            </select>
            <div class="separar">
              <label for="categorias">Categorias</label>
              <select class="form-control" name="categorias" id="categorias"></select>
            </div>
            <div class="row separar">
              <div class="form-group">
                <div class="col-sm-offset-1 col-sm-10">
                  <button type="submit" class="btn btn-default" style="width:130px">Filtrar</button>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group">
                <div class="col-sm-offset-3 col-sm-3">
                  <button type="reset" class="btn btn-default">Reset</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-7 col-md-offset-1 transparente alturaminima" id="lacaja">
      <h3 class="text-center">Gauchadas</h3>
      <div class="container-fluid" id="publicaciones">

      </div>
    </div>
  </div>

</body>
</html>
