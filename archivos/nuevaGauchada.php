<?php
  require("conexionBD.php");
  conectarse($conexion);
  $fActual=date("Y-m-d");
  $fMax=date_create(date("Y-m-d"));
  date_add($fMax, date_interval_create_from_date_string('30 days'));
  $fMax=date_format($fMax, 'Y-m-d');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/estilos.css">
  <script>
    $(document).ready(function(){
      creditosFuncion();
      $.get("selects.php?select=ciudades", function(datos){
        var jDatos= JSON.parse(datos);
        for (var x in jDatos) {
          $('#ciudades').append($('<option>', {value: jDatos[x], text: jDatos[x]}));
        }
      });
      $.get("selects.php?select=categorias", function(datos){
        var jDatos= JSON.parse(datos);
        for (var x in jDatos) {
          $('#categorias').append($('<option>', {value: jDatos[x], text: jDatos[x]}));
        }
      });

      $(".esconderAlerta").on("click keypress", function(){
        $("#alertaForm").addClass('hidden');
      });

      $("#nuevaForm").submit(function(){
        var datosFormulario= $(this).serialize();
        $.post("nuevaGauchadaGuardar.php", datosFormulario, nuevaResp);
        return false;
      });
      function nuevaResp(datos){
        if (datos=="exito") {
          $("#alertaTxt").text("La gauchada se ha creado satisfactoriamente");
          cambiarAlerta(true);
          creditosFuncion();
        } else {
          $("#alertaTxt").text(datos);
          cambiarAlerta(false);
        }
      }
    });
    function creditosFuncion(){
      $.get("datosDelUsuario.php?datos=devolver", function(datos){
        var jDatos= JSON.parse(datos);
        $("#creditosTxt").text("Creditos: "+jDatos.creditos);
        if (jDatos.creditos>0) {
          $("#creditosDiv").addClass('alert-success');
          $("#creditosDiv").removeClass('alert-danger');
          $("#nuevaForm").prop("hidden",false);
        } else {
          $("#creditosDiv").addClass('alert-danger');
          $("#creditosDiv").removeClass('alert-success');
          $("#nuevaForm").prop("hidden",true);
        }
      });
    }
    function cambiarAlerta(tf){
      if (tf) {
        $("#alertaForm").addClass('alert-success');
        $("#alertaForm").removeClass('alert-danger');
      } else {
        $("#alertaForm").addClass('alert-danger');
        $("#alertaForm").removeClass('alert-success');
      }
      $("#alertaForm").removeClass('hidden');
    }
  </script>
</head>
<body>
  <div class="row">
    <div class="col-md-6 col-md-offset-3 transparente">
      <div class="container-fluid">
        <h3 class="separar">Crear Gauchada</h3>
        <div class="row">
          <div class="col-md-11 col-md-offset-1">
            <div class="alert col-md-10 text-center" id="creditosDiv">
              <strong id="creditosTxt"></strong>
            </div>
            <div class="alert col-md-10 hidden text-center" id="alertaForm">
              <strong id="alertaTxt"></strong>
            </div>
            <form class="form-horizontal" action="" method="post" id="nuevaForm">
              <div class="row">
                <div class="col-md-5">
                  <div class="form-group">
                    <label for="titulo" class="control-label">Titulo</label>
                    <input type="text" class="form-control esconderAlerta" id="titulo" placeholder="Titulo" required autofocus pattern="[A-Za-z0-9 ]{3,20}" title="De 3 a 20 letras o numeros" name="titulo">
                  </div>
                </div>
                <div class="col-md-4 col-md-offset-1">
                  <div class="form-group">
                    <label for="ciudades">Ciudad</label>
                    <select class="form-control esconderAlerta" name="ciudad" id="ciudades" required></select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-5">
                  <div class="form-group">
                    <label for="fecha" class="control-label">Limite</label>
                    <input type="date" class="form-control esconderAlerta" id="fecha" min="<?php echo $fActual; ?>" max="<?php echo $fMax; ?>" required name="fecha">
                  </div>
                </div>
                <div class="col-md-4 col-md-offset-1">
                  <div class="form-group">
                    <label for="categoria">Categorias</label>
                    <select class="form-control esconderAlerta" name="categoria" id="categorias" required></select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-10">
                  <div class="form-group">
                    <label for="descrip">Descripcion</label>
                    <textarea name="descrip" rows="5" class="form-control esconderAlerta" placeholder="Escriba una descripcion" required style="resize: none;" maxlength="400"></textarea>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-10">
                  <div class="form-group">
                    <label for="imagen">Agregue una imagen (opcional)</label>
                    <input type="file" name="imagen" accept="image/*" class="esconderAlerta">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-offset-5 col-sm-3">
                  <div class="form-group">
                    <button type="submit" class="btn btn-default">Crear</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
          </div>
        </div>
    </div>
  </div>
</body>
</html>
