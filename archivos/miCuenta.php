<?php
  require("datosDelUsuario.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/estilos.css">

  <script>
    $(".inps").change(function(){
      $("#botonCambiar").prop("disabled", false);
    });
    $("#cambiarDatosForm").submit(function(){
/*      if ( $("#clave").val()!=$("#clave2").val() ) {
        $("#alertaTxt").text("Las claves no coinciden");
        $("#alertaDeClave").removeClass('hidden');
      }else{  */
        var datosFormulario= $(this).serialize();
        $.post("cambiarDatos.php", datosFormulario, cambiarDatosResp);
//      }
      return false;
    });
    function cambiarDatosResp(datos){
      if (datos=="exito") {
        $("#alertaTxt").text("Los datos de la cuenta se han modificado con exito");
        $("#alertaForm").addClass('alert-success');
        $("#alertaForm").removeClass('alert-danger');
        $("#alertaForm").removeClass('hidden');
      } else {
        $("#alertaTxt").text(datos);
        $("#alertaForm").addClass('alert-danger');
        $("#alertaForm").removeClass('alert-success');
        $("#alertaForm").removeClass('hidden');
      }
    }

    function borrarCuenta(){
      var algo;
      $.post("borrarCuenta.php", algo, borrarResp);
    }
    function borrarResp(datos){
      if (datos=="exito") {
        window.location = "index.php";
      } else {
        alert(datos);
      }
    }
  </script>
</head>
<body>
  <div class="row">
    <div class="col-md-6 col-md-offset-3 transparente">
      <h3>Mi cuenta</h3>
      <div class="container-fluid separar">
        <div class="bordeDiv separar">
          <div class="container-fluid fondoGris">
            <h4>Cambiar datos</h4>
          </div>
          <div class="container-fluid fondoBlanco">
            <div class="container-fluid separar">
              <form class="" action="" method="post" id="cambiarDatosForm">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="nombre" class="control-label">Nombre</label>
                      <input type="text" class="form-control inps" id="nombre" value="<?php echo $nom; ?>" required autofocus maxlength="20" name="nombre">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="apellido" class="control-label">Apellido</label>
                      <input type="text" class="form-control inps" id="apellido" value="<?php echo $ap; ?>" required maxlength="20" name="apellido">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="fecha" class="control-label">Fecha de nacimiento</label>
                      <input type="date" class="form-control inps" id="fecha" value="<?php echo $fn; ?>" min="1900-01-01" max="2010-12-31" required name="fecha">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="telefono" class="control-label">Telefono</label>
                      <input type="tel" class="form-control inps" id="telefono" value="<?php echo $tel; ?>" pattern="[0-9]{7,15}" required title="De 7 a 15 numeros" name="telefono">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-offset-5 col-sm-5">
                    <div class="form-group">
                      <button type="submit" class="btn btn-default" id="botonCambiar" disabled>Cambiar</button>
                    </div>
                  </div>
                </div>
              </form>
              <div class="alert col-md-8 col-md-offset-2 hidden text-center" id="alertaForm">
                <strong id="alertaTxt"></strong>
              </div>
            </div>
          </div>
        </div>
        <div class="bordeDiv">
          <div class="container-fluid fondoRojo">
            <h4 class="letraBlanca">Borrar cuenta</h4>
          </div>
          <div class="container-fluid fondoBlanco">
            <div class="row separar">
              <div class="col-md-9">
                <p>ADVERTENCIA: al precionar el boton se borrara la cuenta.</p>
              </div>
              <div class="col-md-3">
                <button type="button" name="borrar" class="btn btn-default" onclick="borrarCuenta()"><strong class="letraRoja">Borrar cuenta</strong></button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
