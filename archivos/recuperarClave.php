<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/estilos.css">
  <script>
  $(document).ready(function() {
    $("#mailForm").submit(function(){
      var datosFormulario= $(this).serialize();
      $.post("php/recuperarClaveValidar.php", datosFormulario, mailRespuesta);
      return false;
    });
    $("#recuperarForm").submit(function(){
      var datosFormulario= {email:$("#inputEmail").val(), clave:$("#inputPassword").val(), resp:$("#respuesta").val()};
      $.post("php/recuperarClaveValidar.php", datosFormulario, validarRespuesta);
      return false;
    });
    function mailRespuesta(datos){
      var JSONresp= JSON.parse(datos);
      if (JSONresp.exito=="true") {
        $("#alertaForm").addClass('hidden');
        $("#subm1").addClass('hidden');
        $("#recuperarForm").prop("hidden",false);
        $("#inputEmail").prop("disabled",true);
        $("#pregunta").text(JSONresp.pregunta);
      } else {
        cambiarAlerta(false, JSONresp.exito);
      }
    }
    function validarRespuesta(datos){
      var JSONresp= JSON.parse(datos);
      if (JSONresp.exito=="exito") {
        cambiarAlerta(true, "La clave ha sido cambiada con exito");
      } else {
        cambiarAlerta(false, JSONresp.exito);
      }
    }
  });
  </script>
</head>
<body>
  <div class="row">
    <div class="col-md-4 col-md-offset-4 transparente">
      <div class="container-fluid">
        <h3 class="separar">Recuperar clave</h3>
        <form class="form-horizontal" action="" method="post" id="mailForm">
          <div class="form-group">
            <label for="inputEmail" class="col-sm-2 col-sm-offset-1 control-label">Email</label>
            <div class="col-sm-8">
              <input type="email" class="form-control" id="inputEmail" placeholder="Email" required autofocus pattern="[A-Za-z0-9._+-]{1,}@[a-z]{1,}.com" title="ejemplo@mail.com" name="email">
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-5 col-sm-4">
              <button type="submit" class="btn btn-default" id="subm1">Continuar</button>
            </div>
          </div>
        </form>
        <form class="form-horizontal" action="" method="post" id="recuperarForm" hidden>
          <div class="form-group">
            <div class="col-sm-10 col-sm-offset-1">
              <label>Pregunta de seguridad</label>
              <div class="col-sm-10 col-sm-offset-1">
                <p id="pregunta"></p>
                <input type="text" class="form-control" id="respuesta" placeholder="Respuesta" required pattern="[A-Za-z0-9]{3,}" title="De 3 a 20 caracteres y solo: A-Z a-z 0-9" maxlength="20" name="resp">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword" class="col-sm-4 control-label">Nueva clave</label>
            <div class="col-sm-7">
              <input type="password" class="form-control" id="inputPassword" placeholder="Clave" required pattern="[A-Za-z0-9]{3,}" title="Minimo 3 caracteres y solo: A-Z a-z 0-9" maxlength="20" name="clave">
            </div>
          </div>
          <div class="col-sm-offset-5 col-sm-4">
            <div class="form-group">
              <button type="submit" class="btn btn-default">Cambiar</button>
            </div>
          </div>
        </form>
        <div class="alert col-md-10 col-md-offset-1 hidden text-center" id="alertaForm">
          <strong id="alertaTxt"></strong>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
