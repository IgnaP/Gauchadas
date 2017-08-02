<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/estilos.css">
  <script>
  $(document).ready(function(){
    $.get("php/datosDelUsuario.php?datos=devolver", function(datos){
      var jDatos= JSON.parse(datos);
      $("#nombreApellido").text(jDatos.nom+" "+jDatos.ap);
      $("#infoFN").append(jDatos.fn);
      $("#infoTel").append(jDatos.tel);
      $("#repNom").text(jDatos.rep);
      if (jDatos.imagen=="") {
        $("#imagenPerfil").prop("src", "css/Logo UnaGauchada.png");
      } else {
        $("#imagenPerfil").prop("src", "imagenes/"+jDatos.imagen);
      }
      barRep(jDatos.pRep);
      funcionCreditos(jDatos.creditos);
    });
    funcionInformacion();

   <?php if(isset($_GET["postulaciones"])){ ?>
  	cambiarPanel("misPostulaciones");
  <?php } ?>
  });
  function barRep(rep){
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
  function funcionCreditos(creditos){
    $("#infoCreditos").text(creditos);
    if (creditos>0) {
      $("#infoCreditos").addClass("text-success");
    } else {
      $("#infoCreditos").addClass("text-danger");
    }
  }
  function funcionInformacion(){
    $("#calificacionesDadas").load("calificacionesDadas.php");
    $("#calificacionesRecibidas").load("calificacionesRecibidas.php");
    $("#misPostulaciones").load("misPostulaciones.php");
  }
  function cambiarPanel(panel){
    $(".panelAbierto").prop("hidden",true);
    if ( $("#"+panel).hasClass("panelAbierto") ) {
      $(".panelAbierto").removeClass("panelAbierto");
    } else {
      $(".panelAbierto").removeClass("panelAbierto");
      $("#"+panel).addClass("panelAbierto");
      $(".panelAbierto").prop("hidden",false);
    }
    $("body,html").animate({ scrollTop: $('body')[0].scrollHeight}, 1000); //para bajar scroll automáticamente
  }
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
    <div class="col-md-2 transparente alturaminima">
      <h3 id="nombreApellido"></h3>
      <div class="separar2">
        <img style="max-width:200px;max-height:200px;" class="center-block" id="imagenPerfil">
      </div>
      <div class="">
        <p id="infoFN">Fecha de nacimiento: </p>
        <p id="infoTel">Telefono: </p>
      </div>
      <div class="">
        <div class="row">
          <div class="col-sm-5"><label>Reputación:</label></div>
          <div class="col-sm-7"><p id="repNom" class="text-left"></p></div>
        </div>
        <div class="progress">
          <div class="progress-bar" role="progressbar" aria-valuemin="10" aria-valuemax="100" id="barRep"></div>
        </div>
      </div>
      <div class="separar">
        <div class="row">
          <b class="col-sm-4">Créditos: </b>
          <div class="col-sm-8"><p id="infoCreditos" class="text-left"></p></div>
        </div>
      </div>
      <div class="col-sm-12">
        <div class="form-group">
          <button type="button" name="button" class="btn btn-default center-block" onclick="cargarPagina('miCuenta.php')">Editar perfil</button>
        </div>
      </div>
    </div>
    <div class="col-md-7 col-md-offset-1 transparente alturaminima">
      <h3 class="text-center separar2">Información</h3>
      <div class="conteiner-fluid" id="historialDiv">
        <div class="panel panel-primary">
          <div class="panel-heading" onclick="cambiarPanel('calificacionesDadas')">
            <div class="row">
              <div class="col-sm-11"><b>Calificaciones dadas</b></div>
              <div class="col-sm-1"><span class="caret"></span></div>
            </div>
          </div>
          <div class="panel-body" hidden id="calificacionesDadas"></div>
        </div>
        <div class="panel panel-primary">
          <div class="panel-heading" onclick="cambiarPanel('calificacionesRecibidas')">
            <div class="row">
              <div class="col-sm-11"><b>Calificaciones recibidas</b></div>
              <div class="col-sm-1"><span class="caret"></span></div>
            </div>
          </div>
          <div class="panel-body" hidden id="calificacionesRecibidas"></div>
        </div>
        <div class="panel panel-primary">
          <div class="panel-heading" onclick="cambiarPanel('misPostulaciones')">
            <div class="row">
              <div class="col-sm-11"><b>Mis postulaciones</b></div>
              <div class="col-sm-1"><span class="caret"></span></div>
            </div>
          </div>
          <div class="panel-body" hidden id="misPostulaciones"></div>
        </div>

      </div>
    </div>
  </div>
  <div class="row separar">
    <div class="col-md-7 col-md-offset-3 transparente">
      <h3 class="text-center">Cuenta</h3>
      <div class="bordeDiv separar">
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
