<?php
  session_start();
  require("conexionBD.php");
  conectarse($conexion);
  $usr=$_SESSION["usuario"];
  $sql="SELECT `ID` FROM `usuarios` WHERE `Email`='$usr'";
  $result=mysqli_query($conexion, $sql);
  $row = mysqli_fetch_row($result);
  $usrID=$row[0];
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
      $("#misPublicaciones").load("publicaciones.php", {"usr": "<?php echo $usrID; ?>"});
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
