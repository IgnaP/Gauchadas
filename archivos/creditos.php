<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/estilos.css">

  <script>
    $(document).ready(function() {
      creditosFuncion();
      for (var i = 1; i < 13; i++) {
        $('#mes').append($('<option>', {value: i, text: i}));
      };
      for (var i = 2017; i < 2040; i++) {
        $('#ao').append($('<option>', {value: i, text: i}));
      };

      $(".esconderAlerta").on("click keypress", function(){
        $("#alerta").addClass('hidden');
      });

      $("#formulario").submit(function(){
        var datosFormulario= $(this).serialize();
        $.post("creditosValidar.php", datosFormulario, compraResp);
        return false;
      });
      function compraResp(datos){
        if (datos=="exito") {
          cambiarAlerta(true, "La compra se ha realizado con exito");
          creditosFuncion();
        } else {
          cambiarAlerta(false, datos);
        }
      }
    });
    function creditosFuncion(){
      $.get("datosDelUsuario.php?datos=devolver", function(datos){
        var jDatos= JSON.parse(datos);
        $("#creditosActuales").text(jDatos.creditos);
      });
    }
    function cambiarAlerta(tf, txt){
      $("#alertaTxt").text(txt);
      if (tf) {
        $("#alerta").addClass('alert-success');
        $("#alerta").removeClass('alert-danger');
      } else {
        $("#alerta").addClass('alert-danger');
        $("#alerta").removeClass('alert-success');
      }
      $("#alerta").removeClass('hidden');
    }
  </script>
</head>
<body>
  <div class="row">
    <div class="col-md-6 col-md-offset-3 transparente">
      <h3 class="separar">Comprar creditos</h3>
      <form class="form-horizontal" action="" method="post" id="formulario">
        <div class="col-md-offset-2 col-md-8">
          <div class="form-group">
            <label for="tipo" class="control-label col-sm-4">Metodo de pago</label>
            <div class="col-md-8">
              <select class="form-control esconderAlerta" name="tipo" id="tipo">
                <option>VISA</option>
                <option>Master Card</option>
                <option>American Express</option>
                <option>Cabal</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="tarjeta" class="control-label col-sm-5">Numero de tarjeta</label>
            <div class="col-md-7">
              <input type="text" class="form-control esconderAlerta" id="tarjeta" placeholder="Tarjeta" required autofocus name="tarjeta" pattern="[0-9]{4,4} [0-9]{4,4} [0-9]{4,4} [0-9]{4,4}" title="Ejemplo: 1234 5678 9012 3456">
            </div>
          </div>
          <div class="form-group">
            <label for="fecha" class="control-label col-sm-5">Fecha de caducidad</label>
            <div class="col-sm-3"><select class="form-control esconderAlerta" name="mes" id="mes"></select></div>
            <div class="col-sm-4"><select class="form-control esconderAlerta" name="ao" id="ao"></select></div>
          </div>
          <div class="form-group">
            <label for="cod" class="control-label col-sm-5">Codigo de seguridad</label>
            <div class="col-md-7">
              <input type="text" class="form-control esconderAlerta" id="cod" placeholder="Codigo" required name="cod" pattern="[0-9]{3,3}" title="Ejemplo: 074">
            </div>
          </div>
          <div class="form-group">
            <label for="cantCreds" class="control-label col-sm-2">Creditos</label>
            <label id="creditosActuales" class="control-label col-sm-1 text-center letraAzul"></label>
            <label class="control-label col-sm-1 text-center">+</label>
            <div class="col-sm-8">
              <input type="number" class="form-control esconderAlerta" id="cantCreds" placeholder="Cantidad" required name="cantCreds" min="1" max="100">
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-5 col-sm-3">
            <button type="submit" class="btn btn-default">Confirmar</button>
          </div>
        </div>
      </form>
      <div class="alert col-md-8 col-md-offset-2 hidden text-center" id="alerta">
        <strong id="alertaTxt"></strong>
      </div>
    </div>
  </div>
</body>
</html>