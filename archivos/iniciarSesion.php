<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/estilos.css">

  <script>
  $(document).ready(function() {
    $("#loginForm").submit(function(){
      var datosFormulario= $(this).serialize();
      $.post("iniciarSesionValidar.php", datosFormulario, loginRespuesta);
      return false;
    });

    function loginRespuesta(datos){
      if (datos=="Usuario") {
        window.location = "sesion.php";
      } else {
        if (datos=="Admin") {
          $("#alertaTxt").text("Lamentablemente la pagina para admins todavia no esta disponible");
          $("#alertaDeClave").removeClass('hidden');
        } else {
          $("#alertaTxt").text(datos);
          $("#alertaDeClave").removeClass('hidden');
        }
      }
    }
  });
  </script>
</head>
<body>
  <div class="row">
    <div class="col-md-4 col-md-offset-4 transparente">
      <div class="container-fluid">
        <h3 class="separar">Iniciar sesion</h3>
        <form class="form-horizontal" action="sesion.php" method="post" id="loginForm">
          <div class="form-group">
            <label for="inputEmail" class="col-sm-2 col-sm-offset-1 control-label">Email</label>
            <div class="col-sm-8">
              <input type="email" class="form-control" id="inputEmail" placeholder="Email" required autofocus pattern="[A-Za-z0-9._+-]{1,}@[a-z]{1,}.com" title="ejemplo@mail.com" name="email">
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword" class="col-sm-2 col-sm-offset-1 control-label">Clave</label>
            <div class="col-sm-8">
              <input type="password" class="form-control" id="inputPassword" placeholder="Clave" required pattern="[A-Za-z0-9]{3,}" title="Minimo 3 caracteres y solo: A-Z a-z 0-9" maxlength="20" name="clave">
            </div>
          </div>
          <div class="container">
            <a onclick="recuperarClave()">Recuperar clave</a>
          </div>
          <div class="alert alert-danger col-md-10 col-md-offset-1 hidden text-center" id="alertaDeClave">
            <strong id="alertaTxt"></strong>
          </div>
          <div class="col-sm-offset-5 col-sm-4">
            <div class="form-group">
              <button type="submit" class="btn btn-default">Enviar</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
