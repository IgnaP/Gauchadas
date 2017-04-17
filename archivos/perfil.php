<?php
  session_start();
  require("conexionBD.php");
  conectarse($conexion);
  $email=$_SESSION["usuario"];
  $consulta="SELECT * FROM Usuarios WHERE Email='$email'";
  $resultado=mysqli_query($conexion,$consulta);
  $fila=mysqli_fetch_row($resultado);
  $nom=$fila[3];$ap=$fila[4];$fn=$fila[5];$tel=$fila[6];
  $fechaN=date("d/m/Y", strtotime($fn));
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
    barRep();
  });
  function barRep(){
    var rep = 0;
    $("#barRep").text(rep);
    if (rep >= 0) {
      if (rep == 0) {
        $("#repNom").addClass("text-info");
        $("#barRep").addClass("progress-bar-info");
        $("#barRep").prop({"aria-valuenow": "10", "style":"width: 10%"});
      } else {
        $("#repNom").addClass("text-success");
        $("#barRep").addClass("progress-bar-success");
        var max =50;
        var porc = ((rep/max)*100);
        if (porc <= 11) {
          porc = 11;
        }else{
          if (porc > 100) {
            porc = 100;
          }
        }
        $("#barRep").prop({"aria-valuenow": porc, "style":"width: "+ porc +"%"});
      }
    } else {
      $("#repNom").addClass("text-danger");
      $("#barRep").addClass("progress-bar-danger");
      $("#barRep").prop({"aria-valuenow": "9", "style":"width: 9%"});
    }
  };
  </script>
</head>
<body>
  <div class="row">
    <div class="col-md-2 transparente alturaminima">
      <h3><?php echo "$nom $ap"; ?></h3>
      <div class="separar2">
        <h3>IMAGEN?</h3>
        <p>Fecha de nacimiento: <?php echo "$fechaN"; ?></p>
        <p>Telefono: <?php echo $tel; ?></p>
      </div>
      <div class="">
        <div class="row">
          <div class="col-sm-5"><label>Reputacion:</label></div>
          <div class="col-sm-7"><p id="repNom" class="text-left">Observador</p></div>
        </div>
        <div class="progress">
          <div class="progress-bar" role="progressbar" aria-valuemin="10" aria-valuemax="100" id="barRep"></div>
        </div>
      </div>

    </div>
    <div class="col-md-7 col-md-offset-1 transparente alturaminima">
      <h3 class="text-center">Historial</h3>

    </div>
  </div>
</body>
</html>
