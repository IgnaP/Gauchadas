<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/estilos.css">
<script>
  var pID=<?php echo $_POST["ID"]; ?>;
  var dueño;
  var usr;
  $(document).ready(function(){
    $.get("php/datosDeLaPublicacion.php?ID="+pID, function(datos){
      var jDatos= JSON.parse(datos);
      $("#titulo").text(jDatos.tit);
      $("#provincia").text(jDatos.prov);
      $("#ciudad").text(jDatos.ciu);
      $("#categoria").text(jDatos.cat);
      $("#descripcion").text(jDatos.desc);
      $("#fecha").text(jDatos.fecha);
      if (jDatos.imagen=="") {
        $("#imagen").prop("src", "css/Logo UnaGauchada.png");
      } else {
        $("#imagen").prop("src", "imagenes/"+jDatos.imagen);
      }
      if (jDatos.logueado) {
        if (jDatos.owner==jDatos.usr) {
          $(".delDueño").prop('hidden', false);
          $.get("debeCalificacionEnPublicacion.php",{pID: pID}, function(debe){
            var jdebe = JSON.parse(debe);
            if (jDatos.activa == 0){
            	 $(".delDueño #botonPostulantes").prop('disabled',true);
            }
            if(jdebe){
              $(".delDueño #botonPostulantes").prop('disabled',true);
            } else {
              if(!jdebe){
                $(".delDueño #calificar").hide();
              }
            }
          });
        } else {
          $(".noDueño").prop('hidden', false);
        }
      }
      if (jDatos.postulado) {
        $("#postularseBot").prop("disabled",true);
        $("#postularseBot").text("Ya esta postulado");
      }
      dueño=jDatos.owner;
      usr=jDatos.usr;
      cargarPreguntas();
    });
  });
  $("#preguntaForm").submit(function(){
    var datosFormulario= $(this).serialize();
    $.post("php/publicacionValidar.php?pregunta="+pID, datosFormulario, publPregResp);
    return false;
  });
  function publPregResp(datos){
    if (datos=="exito") {
      $("#inpPregunta").val("");
      $("#cajaPreguntas").html('');
      cargarPreguntas();
    } else {
      alert(datos);
    }
  }
  $(document).on('submit','#respuestaForm', function(){
    var datosFormulario= $(this).serialize();
    $.post("php/publicacionValidar.php?respuesta=resp", datosFormulario, publResp);
    return false;
  });
  function publResp(datos){
    if (datos=="exito") {
      $("#cajaPreguntas").html('');
      cargarPreguntas();
    } else {
      alert(datos);
    }
  }
  function cargarPreguntas(){
    $.get("php/publicacionValidar.php?cargar="+pID, function(datos){
      var jDatos= JSON.parse(datos);
      for (var x in jDatos) {
        var user= $("<b></b>").append(jDatos[x][3]+" - ");
        if (jDatos[x][3]==usr) {
          var color= $("<span></span>").text(jDatos[x][3]).addClass("letraAzul");
          user= $("<b></b>").append(color," - ");
        }
        var crearPreg= $("<p></p>").append(user,jDatos[x][1]);
        var crearResp= "";
        if (jDatos[x][2]=="") {
          if (dueño==usr) {
            crearResp= $("<a></a>").addClass("puntero botonResp").text("Responder").attr("onclick","eventoResponder(this,"+jDatos[x][0]+")");
          }
        } else {
          var negrita= $("<b></b>").append(dueño+" - ");
          if (dueño==usr) {
            var color= $("<span></span>").text(dueño).addClass("letraAzul");
            negrita= $("<b></b>").append(color," - ");
          }
          crearResp= $("<p></p>").append(negrita,jDatos[x][2]);
        }
        var crearB= $("<div class='col-md-11 col-md-offset-1'></div>").append(crearResp);
        var crearA= $("<div class='row'></div>").append(crearB);
        var crearDiv= $("<div class='separar comentDiv'></div>").append(crearPreg,crearA);
        $("#cajaPreguntas").append(crearDiv);
      }
    });
  }
  function eventoResponder(yo,prueba){
    $(".botonResp").prop("hidden",false);
    $("#respuestaForm").remove();
    $(yo).prop("hidden",true);
    var inpConID= $('<input>').prop({"hidden":true, "name":"inpConID"}).val(prueba);
    var subBot=$('<button type="submit" class="btn btn-default">Publicar</button>');
    var divBa=$('<div class="col-md-3 col-md-offset-5"></div>').append(subBot);
    var divB=$('<div class="row"></div>').append(divBa);
    var inpResp=$('<textarea name="inpRespuesta" rows="3" class="form-control" placeholder="Escriba su respuesta" required style="resize: none;" maxlength="200" id="inpRespuesta"></textarea>');
    var divA=$('<div class="form-group"></div>').append(inpResp);
    var formulario=$('<form action="" method="post" id="respuestaForm"></form>').append(divA,divB,inpConID);
    $(yo).after(formulario);
  }
  function postularseMostrar(tf){
    if (tf) {
      $("#postularseDiv").removeClass("hidden");
      $("#postularseBot").prop("disabled", true);
    } else {
      $("#postularseDiv").addClass("hidden");
      $("#postularseBot").prop("disabled", false);
    }
  }
  $("#postularseForm").submit(function(){
    $.post("postularse.php", {"pID": pID , "coment": $("#coment").val() }, postularseResp);
    return false;
  });
  function postularseResp(datos){
    if (datos=="exito") {
      $("#postularseDiv").addClass("hidden");
      $("#postularseBot").text("Ya esta postulado");
      cambiarAlerta(true, "Se ha postulado en esta gauchada");
    } else {
      cambiarAlerta(false, datos);
    }
  }
  $("#botonModificar").on("click", function(){
    modificarPublicacion(pID);
  });
</script>
</head>
<body>
    <div class="row">
      <div class="col-md-10 col-md-offset-1 transparente">
        <div class="alert col-md-10 col-md-offset-1 hidden separar text-center" id="alertaForm">
          <strong id="alertaTxt"></strong>
        </div>
        <div class="row bordeAbajo">
          <div class="col-md-7 col-md-offset-1">
            <h3 id="titulo"></h3>
            <img style="max-width:500px;max-height:500px;" class="center-block" id="imagen">
            <div class="row separar">
              <div class="col-md-10">
                <label class="label label-primary" id="provincia"></label>
                <label class="label label-primary" id="ciudad"></label>
                <label class="label label-info" id="categoria"></label>
              </div>
              <div class="col-md-2">
                <span id="fecha"></span>
              </div>
            </div>
            <div class="">
              <p class="text-justify" id="descripcion"></p>
            </div>
          </div>
          <div class="col-md-3 col-md-offset-1">
            <div hidden class="delDueño">
              <button type="button" name="button" class="btn btn-default" id="botonModificar">Modificar gauchada</button>
              <button type="button" name="button" class="btn btn-default" id="botonPostulantes" onclick="verPostulantes()">Ver postulantes</button>
              <button type="button" name="button" class="btn btn-default" id="calificar" onclick="calificarPostulante()">Calificar postulante seleccionado</button>
            </div>
            <div hidden class="noDueño">
              <button type="button" name="button" class="btn btn-default" onclick="postularseMostrar(true)" id="postularseBot">Postularse</button>
            </div>
          </div>
        </div>
        <div class="row bordeAbajo hidden" id="postularseDiv">
          <div class="col-sm-offset-1 col-sm-10">
            <h3>Postularse</h3>
            <form class="container-fluid" action="" method="post" id="postularseForm">
              <div class="form-group">
                <textarea name="coment" rows="3" class="form-control" placeholder="Escriba un comentario" required style="resize: none;" maxlength="200" id="coment"></textarea>
              </div>
              <div class="row">
                <div class="col-sm-offset-4 col-sm-3">
                  <div class="form-group">
                    <button type="submit" class="btn btn-default">Postularse</button>
                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="form-group">
                    <button type="button" class="btn btn-default" onclick="postularseMostrar(false)">Cancelar</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-10 col-sm-offset-1">
            <h3>Preguntas</h3>
            <div class="separar" id="cajaPreguntas">

            </div>
            <div hidden class="noDueño container-fluid">
              <form class="" action="" method="post" id="preguntaForm">
                <div class="form-group">
                  <textarea name="inpPregunta" rows="3" class="form-control" placeholder="Escriba su pregunta" required style="resize: none;" maxlength="200" id="inpPregunta"></textarea>
                </div>
                <div class="row">
                  <div class="col-sm-offset-5 col-sm-3">
                    <div class="form-group">
                      <button type="submit" class="btn btn-default">Publicar</button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
</body>
</html>
