<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/estilos.css">
<script>
  var pID=<?php echo $_POST["ID"]; ?>;
  //var dePostulaciones=<?php //echo $_POST["desdePerfil"]; ?>
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
          if(jDatos.tienePostulantes){
            $("#botonModificar").prop('disabled',true);
          }
          $(".delDueño").prop('hidden', false);
          $.get("debeCalificacionEnPublicacion.php",{pID: pID}, function(debe){
            var jdebe = JSON.parse(debe);
            if (jDatos.activa == 0){
            	 $(".delDueño #botonPostulantes, #botonDespublicar, #botonModificar").prop('disabled',true);
            }
            if(jdebe){
              $(".delDueño #botonPostulantes, #botonDespublicar, #botonModificar").prop('disabled',true);
            } else {
              if(!jdebe){
                $("#calificar").hide();
              }
            }
          });
        } else {
          $.get("php/datosDelUsuario.php?datos=devolver", function(datoss){
          var jDatosAdm= JSON.parse(datoss);
          if(jDatosAdm.admin == 1){
            $(".admin").prop('hidden',false);
            if(jDatos.activa == 0){
              $(".admin #botonDespublicaradm").prop('disabled',true);
            }
          } else {
            $(".noDueño").prop('hidden', false);
          }
        });
        }
      }
      if(jDatos.activa == 0){
        $("#botonDesp").css("display",'none');
        $("#preguntaForm").prop('hidden',true);
      }
      if (jDatos.postulado) {
        $("#postularseBot").css("display",'none');
        //$("#postularseBot").text("Ya esta postulado");
      }
      else{
        $("#botonDesp").css("display",'none');
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
      if (jDatos=="") {
        $("#cajaPreguntas").html("<div></div>").addClass("jumbotron").append("<b>No hay preguntas</b>").addClass("text-center");
      } else {
        var vigente;
        var admin;
        $.ajax({ url: "php/datosDeLaPublicacion.php?ID="+pID, type: 'get',
           dataType: 'html',
           async: false,
           success: function(resultado) {
             var jDatos2= JSON.parse(resultado);
             if (jDatos2.activa==1) {
               vigente=true;
             } else {
               vigente=false;
             }
           }
        });
        $.ajax({ url: "php/datosDelUsuario.php?datos=devolver", type: 'get',
           dataType: 'html',
           async: false,
           success: function(resultado) {
             var jDatos2= JSON.parse(resultado);
             if (jDatos2.admin==1) {
               admin=true;
             } else {
               admin=false;
             }
           }
        });
        for (var x in jDatos) {
          var opcionesTF=false;
          //botones modificar y eliminar comentario
          var divOpciones= $("<div class='row'></div>");
          if ( !(admin) ) {
            var opcionModificar= $("<span class='puntero glyphicon glyphicon-pencil' aria-hidden='true'></span>");
            $(divOpciones).append( $("<div class='col-md-1'></div>").append(opcionModificar) );
          }
          var opcionEliminar= $("<span class='puntero glyphicon glyphicon-remove' aria-hidden='true'></span>");
          $(divOpciones).append( $("<div class='col-md-1 col-md-offset-1'></div>").append(opcionEliminar) );
          var opciones= $("<div></div>").append( $("<div class='col-md-1'></div>").append(divOpciones) );
          //div principal
          var crearDiv= $("<div class='separar comentDiv'></div>");
          $(crearDiv).attr("ID","div"+jDatos[x][0]);
          //div de la pregunta
          var user= $("<b></b>");
          if (jDatos[x][3]==usr) {
            var color= $("<span></span>").text(jDatos[x][3]).addClass("letraAzul");
            $(user).append(color," - ");
            opcionesTF=true;
          }else {
            $(user).append(jDatos[x][3]+" - ");
          }
          var textoPreg= $("<span></span>").text(jDatos[x][1]).attr("ID","textoPreg"+jDatos[x][0]);
          var crearPreg= $("<p></p>").append(user,textoPreg);
          var divPreg= $("<div class='row'></div>").append( $("<div class='col-md-11'></div>").append(crearPreg) );
          $(divPreg).attr("ID","preg"+jDatos[x][0]);
          if ((opcionesTF && vigente && (jDatos[x][2]=="")) | admin) {
            if ( !(admin) ) {
              $(opcionModificar).attr("onclick","modificarComentario('preg',"+jDatos[x][0]+")");
            }
            $(opcionEliminar).attr("onclick","eliminarComentario('preg',"+jDatos[x][0]+")");
            $(divPreg).append( $(opciones).html() );
          }
          $(crearDiv).append(divPreg);
          //div de la respuesta
          if (jDatos[x][2]=="") {
            if (dueño==usr) {
              crearResp= $("<a></a>").addClass("puntero botonResp").text("Responder").attr("onclick","eventoResponder(this,"+jDatos[x][0]+")");
              var divResp= $("<div class='row'></div>").append( $("<div class='col-md-10 col-md-offset-1'></div>").append(crearResp) );
              $(crearDiv).append(divResp);
            }
          } else {
            opcionesTF=false;
            var negrita= $("<b></b>");
            if (dueño==usr) {
              var color= $("<span></span>").text(dueño).addClass("letraAzul");
              $(negrita).append(color," - ");
              opcionesTF=true;
            }else {
              $(negrita).append(dueño+" - ");
            }
            var textoResp= $("<span></span>").text(jDatos[x][2]).attr("ID","textoResp"+jDatos[x][0]);
            crearResp= $("<p></p>").append(negrita,textoResp);
            var container= $("<div class='row'></div>").append( $("<div class='col-md-11'></div>").append(crearResp) );
            $(container).attr("ID","resp"+jDatos[x][0]);
            if ((opcionesTF && vigente) | admin) {
              if ( !(admin) ) {
                $(opcionModificar).attr("onclick","modificarComentario('resp',"+jDatos[x][0]+")");
              }
              $(opcionEliminar).attr("onclick","eliminarComentario('resp',"+jDatos[x][0]+")");
              $(container).append( $(opciones).html() );
            }
            var divResp= $("<div class='row'></div>").append( $("<div class='col-md-11 col-md-offset-1'></div>").append(container) );
            $(crearDiv).append(divResp);
          }
          $("#cajaPreguntas").append(crearDiv);
        }
      }
    });
  }
  function modificarComentario(tipo,id){
    cancelar();
    $("#"+tipo+id).hide();
    $("#"+tipo+id).addClass("escondido");
    var canBot=$('<button type="button" class="btn btn-default">Cancelar</button>').attr("onclick","cancelar()");
    var subBot=$('<button type="button" class="btn btn-default">Modificar</button>').attr("onclick","confirmarModificacion('"+tipo+"','"+id+"')");
    var divB=$('<div class="row"></div>').append( $('<div class="col-md-1 col-md-offset-4"></div>').append(subBot),$('<div class="col-md-1 col-md-offset-1"></div>').append(canBot) );
    var inpResp=$('<textarea name="inpModificar" rows="3" class="form-control" placeholder="Comentario" required style="resize: none;" maxlength="200" id="inpModificar"></textarea>');
    if (tipo=="preg") {
      $(inpResp).val( $("#textoPreg"+id).text() );
    } else {
      $(inpResp).val( $("#textoResp"+id).text() );
    }
    var divA=$('<div class="form-group"></div>').append(inpResp);
    var formulario=$('<form action="" method="post" id="modificarForm" class="quitar"></form>').append(divA,divB);
    $("#"+tipo+id).after(formulario);
  }
  function confirmarModificacion(tipo,id){
    $.post("php/modificarComentario.php", {"id": id , "tipo": tipo , "texto": $("#inpModificar").val() } , function(){
      $("#cajaPreguntas").html('');
      cargarPreguntas();
    });
  }
  function eliminarComentario(tipo,id){
    cancelar();
    if (tipo=="preg") {
      var idCompleta="#div"+id;
    } else {
      var idCompleta="#resp"+id;
    }
    $(idCompleta).hide();
    $(idCompleta).addClass("escondido");
    var bot2=$('<button type="button" class="btn btn-default">Cancelar</button>').attr("onclick","cancelar()");
    var bot1=$('<button type="button" class="btn btn-default">Eliminar</button>').attr("onclick","confirmarEliminacion('"+tipo+"','"+id+"')");
    var div=$('<div class="row separar quitar"></div>').append( $('<div class="col-md-1 col-md-offset-4"></div>').append(bot1),$('<div class="col-md-1 col-md-offset-1"></div>').append(bot2) );
    $(idCompleta).after(div);
  }
  function confirmarEliminacion(tipo,id){
    $.post("php/eliminarComentario.php", {"id": id , "tipo": tipo } , function(){
      $("#cajaPreguntas").html('');
      cargarPreguntas();
    });
  }
  function cancelar(){
    $(".escondido").show();
    $(".escondido").removeClass("escondido");
    $(".quitar").remove();
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
      $("body,html").animate({ scrollTop: $('body')[0].scrollHeight}, 1000); //para bajar scroll automáticamente
    } else {
      $("#postularseDiv").addClass("hidden");
      $("#postularseBot").prop("disabled", false);
      $("body,html").animate({ scrollTop: '0px'}, 500); //para subir scroll automáticamente
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
      setTimeout("cargarPublicacion(pID)", 1000);
    } else {
      cambiarAlerta(false, datos);
    }
  }
  $("#botonModificar").on("click", function(){
    modificarPublicacion(pID);
  });

  $("#botonDespublicar").on("click", function(){
    despublicarGauchada(pID);
  });
  $("#botonDespublicaradm").on("click", function(){
    despublicarGauchadaAdm(pID);
  });
  $("#botonDesp").on("click",function(){
    despostularse(pID);
  });
  function volverAPerfil(){
    $("#lacaja").load("perfil.php?postulaciones="+true);
  }
</script>
</head>
<body>
    <?php if(isset($_POST["desdePerfil"])){ ?>
    <div class="row separar">
      <div class="col-md-2 col-md-offset-1">
        <button type="button" class="btn btn-default" onclick="volverAPerfil()">Volver a mis postulaciones</button>
      </div> <?php } ?>
    </div>
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
              <button type="button" name="button" class="btn btn-default" id="botonDespublicar">Despublicar gauchada</button>
              <button type="button" name="button" class="btn btn-default" id="botonPostulantes" onclick="verPostulantes()">Ver postulantes</button>
              <button type="button" name="button" class="btn btn-default" id="calificar" onclick="calificarPostulante()">Calificar postulante seleccionado</button>
            </div>
            <div hidden class="noDueño">
              <button type="button" name="button" class="btn btn-default" onclick="postularseMostrar(true)" id="postularseBot">Postularse</button>
              <button type="button" name="button" class="btn btn-default" id="botonDesp">Despostularse</button>
            </div>
            <div hidden class="admin">
              <button type="button" name="button" class="btn btn-default" id="botonDespublicaradm">Despublicar gauchada</button>
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
}
</body>
</html>
