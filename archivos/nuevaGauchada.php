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
      $("#nuevaForm").submit(function(){
        var datosFormulario= $(this).serialize();
        $.post("nuevaGauchadaGuardar.php", datosFormulario, nuevaResp);
        return false;
      });

      function nuevaResp(datos){
        if (datos=="exito") {
          $("#alertaTxt").text("La gauchada se ha creado satisfactoriamente");
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
    });
  </script>
</head>
<body>
  <div class="row">
    <div class="col-md-6 col-md-offset-3 transparente">
      <div class="container-fluid">
        <h3 class="separar">Crear Gauchada</h3>
        <div class="row">
          <div class="col-md-11 col-md-offset-1">
            <form class="form-horizontal" action="" method="post" id="nuevaForm">
              <div class="row">
                <div class="col-md-5">
                  <div class="form-group">
                    <label for="titulo" class="control-label">Titulo</label>
                    <input type="text" class="form-control" id="titulo" placeholder="Titulo" required autofocus pattern="[A-Za-z0-9 ]{3,20}" title="De 3 a 20 letras o numeros" name="titulo">
                  </div>
                </div>
                <div class="col-md-4 col-md-offset-1">
                  <div class="form-group">
                    <label for="ciudades">Ciudad</label>
                    <select class="form-control" name="ciudad" id="ciudades" required>
                      <?php
                        require("cargaCiudades.php");
                      ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-5">
                  <div class="form-group">
                    <label for="fecha" class="control-label">Limite</label>
                    <input type="date" class="form-control" id="fecha" min="<?php echo $fActual; ?>" max="<?php echo $fMax; ?>" required name="fecha">
                  </div>
                </div>
                <div class="col-md-4 col-md-offset-1">
                  <div class="form-group">
                    <label for="categoria">Categorias</label>
                    <select class="form-control" name="categoria" id="categorias" required>
                      <?php
                        require("cargaCategorias.php");
                      ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-10">
                  <div class="form-group">
                    <label for="descrip">Descripcion</label>
                    <textarea name="descrip" rows="5" class="form-control" placeholder="Escriba una descripcion" required style="resize: none;" maxlength="400"></textarea>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-10">
                  <div class="form-group">
                    <label for="imagen">Agregue una imagen (opcional)</label>
                    <input type="file" name="imagen" accept="image/*">
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
            <div class="alert col-md-8 col-md-offset-2 hidden text-center" id="alertaForm">
              <strong id="alertaTxt"></strong>
            </div>
          </div>
          </div>
        </div>
    </div>
  </div>
</body>
</html>
