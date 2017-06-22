<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/estilos.css">
  <script>
    var pID;
    $.ajax({ url: "php/buscarCookie.php?nombre=modificarGauchada", type: 'get',
       dataType: 'html',
       async: false,
       success: function(resultado) {
         pID=resultado;
       }
    });
    $(document).ready(function(){
      inicializar();

      $(".esconderAlerta").on("click keypress", function(){
        $("#alertaForm").addClass('hidden');
      });
    });
    function inicializar(){
      $.post("php/guardarCookie.php?nombre=modificarGauchada&valor="+pID);
      cargarCategorias('');
      limitarFecha();
      $.get("php/datosDeLaPublicacion.php?ID="+pID, function(datos){
        var jDatos= JSON.parse(datos);
        $("#titulo").val(jDatos.tit);
        $("#categorias").val(jDatos.cat);
        $("#descripcion").val(jDatos.desc);
        $("#fecha").val(jDatos.fechaOriginal);
        cargarProvincias("");
        $("#provincias").val(jDatos.prov);
      });
      $.get("php/buscarCookie.php?nombre=respuesta", function (resultado, status){
        if (resultado!="false") {
          if (resultado=="exito") {
            cambiarAlerta(true, "La gauchada se ha modificado satisfactoriamente");
          } else {
            cambiarAlerta(false, resultado);
          }
        }
      });
    }
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
    }
  </script>
</head>
<body>
  <div class="row">
    <div class="col-md-6 col-md-offset-3 transparente">
      <div class="container-fluid">
        <h3 class="separar">Modificar Gauchada</h3>
        <div class="row">
          <div class="col-md-11 col-md-offset-1">
            <div class="alert col-md-10 hidden text-center" id="alertaForm">
              <strong id="alertaTxt"></strong>
            </div>
            <form class="form-horizontal" action="php/modificarPublicacion.php" method="POST" id="nuevaForm" enctype="multipart/form-data">
              <div class="row">
                <div class="col-md-10">
                  <div class="form-group">
                    <label for="titulo" class="control-label">Titulo</label>
                    <input type="text" class="form-control esconderAlerta" id="titulo" placeholder="Titulo" required autofocus pattern="[A-Za-z0-9áéíóú ]{3,30}" title="De 3 a 30 letras o numeros" name="titulo">
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
                    <select class="form-control esconderAlerta" name="ciudad" id="ciudades" required>
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
                    <textarea name="descrip" rows="5" class="form-control esconderAlerta" placeholder="Escriba una descripcion" required style="resize: none;" maxlength="400" id="descripcion"></textarea>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-10">
                  <div class="form-group">
                    <label for="imagen">Agregue una imagen (opcional)</label>
                    <input type="file" accept="image/jpeg,image/png,image/jpg" class="esconderAlerta" name="imagen" id="imagen">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-offset-5 col-sm-3">
                  <div class="form-group">
                    <button type="submit" class="btn btn-default">Confirmar</button>
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
