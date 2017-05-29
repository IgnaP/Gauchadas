<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/estilos.css">
  <script src="js/miScrips.js"></script>
  <script>
    $(document).ready(function(){
      $("#publicaciones").load("publicaciones.php");
      marcarPestaña("#pestgauchadas");

      $("#filtrarForm").submit(function(){
        $("#publicaciones").load("publicaciones.php", {"tit": $("#titulo").val(), "cat": $("#categorias").val(), "prov": $("#provincias").val(), "ciu": $("#ciudades").val()});
        return false;
      });
      cargarProvincias('Todas');
      cargarCategorias('Todas');
    });
  </script>
</head>
<body>
  <div class="row">
    <div class="col-md-2 filtros alturaminima" id="lado">
      <div class="row">
        <div class="col-md-10 col-md-offset-1">
          <h3>Filtros</h3>
          <form class="" action="" method="post" id="filtrarForm">
            <input type="text" class="form-control separar" placeholder="Buscar" id="titulo">
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
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-3">
                <button type="submit" class="btn btn-default">Filtrar</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-7 col-md-offset-1 transparente alturaminima" id="gauchadas">
      <h3 class="text-center">Gauchadas</h3>
      <div class="container-fluid" id="publicaciones">

      </div>
    </div>
  </div>
</body>
</html>
