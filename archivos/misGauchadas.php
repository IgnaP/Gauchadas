<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/estilos.css">
  <script>
    $(document).ready(function(){
      marcarPestaña("#pestMG");
      $.get("datosDelUsuario.php?datos=devolver", function(datos){
        var jDatos= JSON.parse(datos);
        $("#misPublicaciones").load("publicaciones.php", {"usr": jDatos.ID});
      });
    });
  </script>
</head>
<body>
  <div class="row">
    <div class="col-md-8 col-md-offset-2 transparente alturaminima" id="gauchadas">
      <h3 class="text-center">Mis Gauchadas</h3>
      <div class="container-fluid" id="misPublicaciones">

      </div>
    </div>
  </div>
</body>
</html>
