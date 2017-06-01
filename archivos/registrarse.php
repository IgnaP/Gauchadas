<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/estilos.css">
  <script>
    $(document).ready(function() {
      marcarPestaña("#pestReg");
      $.get("php/buscarCookie.php?nombre=respuesta", function (resultado, status){
        if (resultado!="false") {
          cambiarAlerta(false, resultado);
        }
      });
      $(".esconderAlerta").change(function(){
        $("#alertaForm").addClass('hidden');
      });

      $.get("selects.php?select=preguntas", function(datos){
        var jDatos= JSON.parse(datos);
        for (var x in jDatos) {
          $('#preguntas').append($('<option>', {value: jDatos[x], text: jDatos[x]}));
        }
      });

      $("#formulario").submit(function(){
        if (! compararClaves() ) {
          return false;
        }
      });
    });
    function compararClaves(){
      if ( ($("#clave").val()!="")&&($("#clave2").val()!="") ) {
        if ( $("#clave").val()!=$("#clave2").val() ) {
          cambiarAlerta(false,"Las claves no coinciden")
          return false;
        }else {
          return true;
        }
      }
    }
  </script>
</head>
<body>
  <div class="row">
    <div class="col-md-6 col-md-offset-3 transparente">
      <div class="row">
        <div class="col-md-9">
          <h3 class="separar">Crear cuenta</h3>
        </div>
      </div>
      <div class="alert col-md-8 col-md-offset-2 hidden text-center" id="alertaForm">
        <strong id="alertaTxt"></strong>
      </div>
      <form class="form-horizontal" action="registrarseGuardar.php" method="post" id="formulario" enctype="multipart/form-data">
        <div class="form-group">
          <div class="row">
            <div class="col-md-4 col-md-offset-2">
              <label for="nombre" class="control-label">Nombre</label>
              <input type="text" class="form-control esconderAlerta" id="nombre" placeholder="Nombre" required autofocus maxlength="20" name="nombre" pattern="[a-zA-Záéíóú ]{3,20}" title="De 3 a 20 letras">
            </div>
            <div class="col-md-4">
              <label for="apellido" class="control-label">Apellido</label>
              <input type="text" class="form-control esconderAlerta" id="apellido" placeholder="Apellido" required maxlength="20" name="apellido" pattern="[a-zA-Záéíóú ]{3,20}" title="De 3 a 20 letras">
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-4 col-md-offset-2">
              <label for="fecha" class="control-label">Fecha de nacimiento</label>
              <input type="date" class="form-control esconderAlerta" id="fecha" placeholder="Fecha" min="1900-01-01" max="2010-12-31" required name="fecha">
            </div>
            <div class="col-md-4">
              <label for="telefono" class="control-label">Telefono</label>
              <input type="tel" class="form-control esconderAlerta" id="telefono" placeholder="Telefono" pattern="[0-9]{7,15}" required title="De 7 a 15 numeros" name="telefono">
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-8 col-md-offset-2">
              <label for="email" class="control-label">Email</label>
              <input type="email" class="form-control esconderAlerta" id="email" placeholder="Email" required pattern="[A-Za-z0-9._+-]{1,}@[a-z]{1,}.com" title="ejemplo@mail.com" name="email">
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-4 col-md-offset-2">
              <label for="clave" class="control-label">Clave</label>
              <input type="password" class="form-control esconderAlerta" id="clave" placeholder="Clave" required pattern="[A-Za-z0-9]{3,}" title="De 3 a 20 caracteres y solo: A-Z a-z 0-9" maxlength="20" name="clave">
            </div>
            <div class="col-md-4">
              <label for="clave2" class="control-label">Confirmar clave</label>
              <input type="password" class="form-control esconderAlerta" id="clave2" placeholder="Confirmar clave" required pattern="[A-Za-z0-9]{3,}" title="De 3 a 20 caracteres y solo: A-Z a-z 0-9" maxlength="20" name="clave2">
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-8 col-md-offset-2">
              <label for="preguntas" class="control-label">Pregunta de seguridad</label>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 col-md-offset-2">
                <select class="form-control esconderAlerta" name="preguntas" id="preguntas">

                </select>
            </div>
            <div class="col-md-4">
              <input type="text" class="form-control esconderAlerta" id="respuesta" placeholder="Respuesta" required pattern="[A-Za-z0-9]{3,}" title="De 3 a 20 caracteres y solo: A-Z a-z 0-9" maxlength="20" name="respuesta">
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-10 col-md-offset-2">
              <label for="imagen">Agregue una imagen (opcional)</label>
              <input type="file" accept="image/jpeg,image/png,image/jpg" class="esconderAlerta" name="imagen" id="imagen">
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-5 col-sm-3">
            <button type="submit" class="btn btn-default">Confirmar</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
