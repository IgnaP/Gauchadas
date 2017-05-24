<?php
  require("conexionBD.php");
  conectarse($conexion);
#  $fActual=date("Y-m-d");
#  $fMax=date_create(date("Y-m-d"));
#  date_add($fMax, date_interval_create_from_date_string('30 days'));
#  $fMax=date_format($fMax, 'Y-m-d');
?>
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
      creditosFuncion();
      cargarProvincias('');
      cargarCategorias('');
      limitarFecha();

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
          cambiarAlerta(true, "La gauchada se ha creado satisfactoriamente");
          creditosFuncion();
        } else {
          cambiarAlerta(false, datos);
        }
      }
    });
    function limitarFecha(){
      var fechaActual=new Date();
      var dia= fechaActual.getDate();
      if (dia<10) {
        dia= "0"+dia;
      }
      var mes= fechaActual.getMonth()+1;
      if (mes<10) {
        mes= "0"+mes;
      }
      var fecha= fechaActual.getFullYear()+"-"+mes+"-"+dia;
      $("#fecha").prop("min", fecha);
    //  fecha= (fechaActual.getFullYear()+100)+"-"+mes+"-"+dia;
    //  $("#fecha").prop("max", fecha);
    }
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
          cambiarAlerta(false, "Necesita por lo menos 1 credito");
        }
      });
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
            <form class="form-horizontal" action="" method="post" id="nuevaForm" hidden>
              <div class="row">
                <div class="col-md-10">
                  <div class="form-group">
                    <label for="titulo" class="control-label">Titulo</label>
                    <input type="text" class="form-control esconderAlerta" id="titulo" placeholder="Titulo" required autofocus pattern="[A-Za-z0-9 ]{3,20}" title="De 3 a 20 letras o numeros" name="titulo">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-5">
                  <div class="form-group">
                    <label for="ciudades">Provincias</label>
                    <select class="form-control esconderAlerta" name="provincias" id="provincias" onchange="localidadesFuncion('')" required></select>
                  </div>
                </div>
                <div class="col-md-4 col-md-offset-1">
                  <div class="form-group">
                    <label for="ciudades">Ciudad</label>
                    <select class="form-control esconderAlerta" name="ciudad" id="ciudades" disabled required>
                      <option value=""></option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-5">
                  <div class="form-group">
                    <label for="fecha" class="control-label">Limite</label>
                    <input type="date" class="form-control esconderAlerta" id="fecha" required name="fecha">
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