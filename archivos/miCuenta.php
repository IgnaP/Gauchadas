<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/estilos.css">
  <script>
  $(document).ready(function(){
    $.get("php/buscarCookie.php?nombre=respuesta", function (resultado, status){
      if (resultado!="false") {
        if (resultado=="exito") {
          nombreDelUsuario();
          cambiarAlerta(true, "Los datos de la cuenta se han modificado con exito");
        } else {
          cambiarAlerta(false, resultado);
        }
      }
    });
    var pregunta;
    $.get("php/datosDelUsuario.php?datos=devolver", function(datos){
      var jDatos= JSON.parse(datos);
      $("#nMail").val(jDatos.email);
      $("#nombre").val(jDatos.nom);
      $("#apellido").val(jDatos.ap);
      $("#fecha").val(jDatos.fn2);
      $("#telefono").val(jDatos.tel);
      $("#respuesta").val(jDatos.resp);
      pregunta=jDatos.pre;
      $.get("php/selects.php?select=preguntas", function(datos){
        var jDatos= JSON.parse(datos);
        for (var x in jDatos) {
          if (jDatos[x]==pregunta) {
            $('#preguntas').append($('<option>', {value: jDatos[x], text: jDatos[x], selected: true}));
          } else {
            $('#preguntas').append($('<option>', {value: jDatos[x], text: jDatos[x]}));
          }
        }
      });
    });
  });
    $("input").click(function(){
      $("#alertaForm").addClass("hidden");
    });
    $(".inps").change(function(){
      $("#botonCambiar").prop("disabled", false);
    });

    $("#borrarCForm").submit(function(){
      var datosFormulario= $(this).serialize();
      $.post("php/borrarCuenta.php", datosFormulario, borrarResp);
      return false;
    });
    function borrarResp(datos){
      if (datos=="exito") {
        window.location = "index.php";
      } else {
        cambiarAlerta(false, datos);
      }
    }
  </script>
</head>
<body>
  <div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="row">
          <div class="alert col-md-10 col-md-offset-1 hidden text-center" id="alertaForm">
            <strong id="alertaTxt"></strong>
          </div>
        </div>
        <div class="bordeDiv">
          <div class="container-fluid fondoGris">
            <h4>Cambiar mis datos</h4>
          </div>
          <div class="container-fluid fondoBlanco">
            <div class="container-fluid separar">
              <form class="" action="php/cambiarDatos.php" method="post" id="cambiarDatosForm" enctype="multipart/form-data">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="email" class="control-label">Email</label>
                      <input type="email" class="form-control inps" id="nMail" placeholder="Email" required pattern="[A-Za-z0-9._+-]{1,}@[a-z]{1,}.com" title="ejemplo@mail.com" name="nMail">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="nombre" class="control-label">Nombre</label>
                      <input type="text" class="form-control inps" id="nombre" required autofocus maxlength="20" name="nombre">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="apellido" class="control-label">Apellido</label>
                      <input type="text" class="form-control inps" id="apellido" required maxlength="20" name="apellido">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="fecha" class="control-label">Fecha de nacimiento</label>
                      <input type="date" class="form-control inps" id="fecha" min="1900-01-01" max="2010-12-31" required name="fecha">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="telefono" class="control-label">Telefono</label>
                      <input type="tel" class="form-control inps" id="telefono" pattern="[0-9]{7,15}" required title="De 7 a 15 numeros" name="telefono">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="clave" class="control-label">Clave actual (obligatorio)</label>
                      <input type="password" class="form-control" id="clave" placeholder="Clave" required pattern="[A-Za-z0-9]{3,}" title="De 3 a 20 caracteres y solo: A-Z a-z 0-9" maxlength="20" name="clave">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="claveN" class="control-label">Nueva clave</label>
                      <input type="password" class="form-control inps" id="claveN" placeholder="Nueva clave" pattern="[A-Za-z0-9]{3,}" title="De 3 a 20 caracteres y solo: A-Z a-z 0-9" maxlength="20" name="claveN">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="preguntas" class="control-label">Pregunta de seguridad</label>
                      <select class="form-control inps" name="preguntas" id="preguntas"></select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="respuesta" class="control-label">Respuesta de seguridad</label>
                      <input type="text" class="form-control inps" id="respuesta" placeholder="Respuesta" required pattern="[A-Za-z0-9]{3,}" title="De 3 a 20 caracteres y solo: A-Z a-z 0-9" maxlength="20" name="respuesta">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-10">
                    <div class="form-group">
                      <label for="imagen">Cambiar imagen</label>
                      <input type="file" accept="image/jpeg,image/png,image/jpg" class="inps" name="imagen" id="imagen">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-offset-5 col-sm-5">
                    <button type="submit" class="btn btn-default" id="botonCambiar" disabled>Cambiar</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="bordeDiv" hidden>
          <div class="container-fluid fondoRojo">
            <h4 class="letraBlanca">Borrar cuenta</h4>
          </div>
          <div class="container-fluid fondoBlanco">
            <div class="row separar">
              <form class="form-horizontal" action="" method="post" id="borrarCForm">
                <label for="clave" class="control-label col-md-1">Clave</label>
                <div class="col-md-5">
                  <input type="password" class="form-control" id="clave" placeholder="Clave" required pattern="[A-Za-z0-9]{3,}" title="De 3 a 20 caracteres y solo: A-Z a-z 0-9" maxlength="20" name="clave">
                </div>
                <div class="col-md-3 col-md-offset-3">
                  <button type="submit" name="borrar" class="btn btn-default"><strong class="letraRoja">Borrar cuenta</strong></button>
                </div>
              </form>
            </div>
          </div>
        </div>
    </div>
  </div>
</body>
</html>
