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
  $("#formu").submit(function(){
    $("#informe").load("informeGanancias.php", {"fecha1": $("#fecha_inicio").val(), "fecha2": $("#fecha_fin").val()});
    return false;
  });
});
</script>
<body>
  <div class="row">
    <div class="transparente col-md-6 col-md-offset-3">
      <div>
        <h2 class="text-center">Informe de ganancias</h2>
      </div>
        <form class="form-horizontal"  method="post" id="formu">
          <div class="form-group">
              <div class="col-sm-15 text-center">
                <label> Ingrese las fechas de las cuales quiere ver el informe: </label>
              </div>
          </div>
          <div class="alert col-md-10 col-md-offset-1 hidden text-center" id="alertaForm">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <strong id="alertaTxt"></strong>
          </div>
          <div class="form-group">
              <div class="col-sm-15 text-center" >
                <label for="fecha" class="control-label"> Desde: </label>
                <input id="fecha_inicio" type="date" max="<?php echo date("Y-m-d");?>" required>
              </div>
          </div>
          <div class="form-group">
            <div class="col-sm-15 text-center">
              <label> Hasta: </label>
              <input type="date" id="fecha_fin" max="<?php echo date("Y-m-d");?>" required>
            </div>
          </div>
          <div class="form-group">
          <div class="col-sm-offset-5 col-sm-5">
            <button type="submit" class="btn btn-default">Confirmar</button>
          </div>
          </div>
        </form>

  <div id="informe" class="container-fluid">

  </div>
</div>
</div>
</body>
</html>
