function cargarPagina(pag){
  $("li").removeClass("active");
  $("#lacaja").load(pag);
}
function marcarPestaña(pest){
  $(pest).addClass("active");
}
function nombreDelUsuario(){
  $.get("php/datosDelUsuario.php?datos=devolver", function(datos){
    var jDatos= JSON.parse(datos);
    $("#nombreUsuario").text(jDatos.email);
  });
}
function cargarPublicacion(pID){
  $("li").removeClass("active");
  $("#lacaja").load("publicacion.php",{"ID":pID});
}

$(document).on('click','.publicacionDiv', function(){
  var pID= $("label:first", this).text();
  cargarPublicacion(pID);
});

function cargarProvincias(porDefecto){
  $('#provincias').html( $('<option>', {value: porDefecto, text: porDefecto}) );
  $.ajax({ url: "php/selects.php?select=provincias", type: 'get', dataType: 'html',
     async: false,
     success: function(datos) {
       var jDatos= JSON.parse(datos);
       for (var x in jDatos) {
         $('#provincias').append($('<option>', {value: jDatos[x], text: jDatos[x]}));
       }
     }
  });
}
function localidadesFuncion(porDefecto){
  $('#ciudades').html( $('<option>', {value: porDefecto, text: porDefecto}) );
  var seleccionado= $("#provincias").val();
  if ( (seleccionado!="Todas") && (seleccionado!='') ) {
    $("#ciudades").prop("disabled",false);
    $.ajax({ url: "php/selects.php?select=localidades&prov="+seleccionado, type: 'get', dataType: 'html',
       async: false,
       success: function(datos) {
         var jDatos= JSON.parse(datos);
         for (var x in jDatos) {
           $('#ciudades').append($('<option>', {value: jDatos[x], text: jDatos[x]}));
         }
       }
    });
  }else {
    $("#ciudades").prop("disabled",true);
  }
}
function cargarCategorias(porDefecto){
  $('#categorias').html( $('<option>', {value: porDefecto, text: porDefecto}) );
  $.ajax({ url: "php/selects.php?select=categorias", type: 'get', dataType: 'html',
     async: false,
     success: function(datos) {
       var jDatos= JSON.parse(datos);
       for (var x in jDatos) {
         $('#categorias').append($('<option>', {value: jDatos[x], text: jDatos[x]}));
       }
     }
  });
}
function cambiarAlerta(tf, txt){
  $("#alertaTxt").text(txt);
  if (tf) {
    $("#alertaForm").addClass('alert-success');
    $("#alertaForm").removeClass('alert-danger');
  } else {
    $("#alertaForm").addClass('alert-danger');
    $("#alertaForm").removeClass('alert-success');
  }
  $("#alertaForm").removeClass('hidden');
}

function obtenerDatosConID(pID, usrID, usrN){
	$.get("obtenerDatosPostulante.php",{ID: usrID}, function(datosP){
		var postulante = JSON.parse(datosP);
		obtener(pID, usrID, usrN, postulante.email, postulante.tel, seleccionarPostulante);
	});
}

function obtener(pID, usrID, usrN, emailP, telP, seleccionarPostulante){
  $.get("obtenerPostulantes.php",{pID: pID, uID: usrID}, function(datos){
  var datosJ = JSON.parse(datos);
  if(datosJ == ""){
    datosJ[0]="(No tiene más postulantes)";
  }
  $.confirm({
    title: 'Confirmación de postulante seleccionado',
    content: 'Está por seleccionar a <strong>'+usrN+'</strong> y rechazar a los siguientes postulantes: '+'<br/>'+'<br/>'+datosJ.join('<br/>'),
    buttons: {
        Aceptar: function () {
            seleccionarPostulante(usrN, pID, usrID, emailP, telP);
        },
        cancelar: function () {
      }
   }
  });
  });
}

function seleccionarPostulante(usrN, pID, usrID, emailP, telP){
  $.get("php/datosDelUsuario.php?datos=devolver", function(datosU){
    var jDatos = JSON.parse(datosU);
    $.confirm({
      title: 'Envio de datos para la comunicación',
      content: 'Seleccionó al postulante <strong>'+usrN+'</strong> y se le enviará un mensaje de correo con los siguientes datos personales: '+'<br/><br/>'
                +'Nombre: '+jDatos.nom+'<br/>'+'Email: '+jDatos.email + '<br/> Teléfono: '+jDatos.tel+'<br/><br/> Además se le enviará a su correo los siguientes '
                +'datos de '+usrN+': <br/><br/> Nombre: '+usrN+'<br/> Email: '+emailP+'<br/> Teléfono: '+telP,
      buttons: {
        Aceptar: function () {
            $.get("modificarPorSeleccionado.php",{pID: pID, usrACalificar: usrID});
            volverAPublicacion(pID);
        }
      }
    });
  });
}

function volverAPublicacion(pID){
  $("li").removeClass("active");
  $("#lacaja").load("publicacion.php",{"ID":pID});
}

function calificar(pID){
  $.get('obtenerPostulanteSeleccionado.php',{pID: pID}, function(datos){
    var usr = JSON.parse(datos);
  $.confirm({
    title: 'Calificación para '+usr.nombre,
    content: '' +
    '<form action="calificar.php" class="formulario" method="post">' +
    '<div class="puntaje">' +
    '<label>Puntaje</label></br>' +
    '<input type="radio" name="puntaje" value="-1"> Negativo </br>'+
    '<input type="radio" name="puntaje" value="0"> Neutro </br>'+
    '<input type="radio" name="puntaje" value="1"> Positivo </br>' +
    '</div>' +
    '<div class="errorPuntaje letraRoja"> </div>' +
    '<div class="form-group">' +
    '<label>Comentario</label>' +
    '<textarea name="comentario" class="comentario" rows = "4" cols ="43" placeholder="Escriba su comentario" maxlength="150" >' +
    '</textarea>' +
    '</div>'+
    '<div class="errorComentario letraRoja"> </div>'+
    '</form>',
    buttons: {
        formSubmit: {
            text: 'Calificar',
            btnClass: 'btn-blue',
            action: function () {
                var puntaje = this.$content.find('input:radio[name="puntaje"]:checked').val();
                var comentario = this.$content.find('.comentario').val();
                var errorPuntaje = this.$content.find(".errorPuntaje");
                var errorComentario = this.$content.find(".errorComentario");
                if(!puntaje){
                  errorPuntaje.html('Debe seleccionar un puntaje').slideDown(200);
                  return false;
                } else {
                    errorPuntaje.hide();
                    if(!comentario){
                      errorComentario.html('Debe escribir un comentario').slideDown(200);
                    return false;
                  } else {
                      errorComentario.hide();
                      errorPuntaje.hide();
                      $.get('guardarCalificacion.php',{puntaje: puntaje, comentario: comentario, uID: usr.id, pID: pID});
                      $.confirm({
                        title: ' ',
                        content: 'Calificado' ,
                       buttons: {
                         Aceptar: function () {
                            volverAPublicacion(pID);
                          }
                        }
                      });
                  }
                }
            }
        },
        cancelar: function () {
        },
    },
  });
});
}

function despublicarGauchada(pID){
  $.confirm({
      title: 'Confirmación despublicar',
      content: 'La gauchada será despublicada',
      buttons: {
        Aceptar: function () {
          $.get("tienePostulantes.php",{pID: pID}, function(datos){
            var postulantes;
            if(!datos){
            postulantes = 0;
            $.confirm({
              title: 'Gauchada despublicada',
              content: 'Su gauchada ha sido despublicada. </br> Se le devolverá el crédito de la publicación',
              buttons: {
                Aceptar: function () {
                  $.get("despublicarGauchada.php",{pID: pID, tiene: postulantes});
                  volverAPublicacion(pID);
                }
              }
            });
            } else {
              postulantes = 1;
              $.confirm({
                title: 'Gauchada despublicada',
                content: 'Su gauchada ha sido despublicada. </br> <strong>No</strong> se le devolverá el crédito de la publicación',
                buttons: {
                  Aceptar: function () {
                    $.get("despublicarGauchada.php",{pID: pID, tiene: postulantes});
                    volverAPublicacion(pID);
                  }
                }
              });
            }
          });
        },
        Cancelar: function(){}
      }
      });
}

function despublicarGauchadaAdm(pID){
      var postulantes = 1;
      $.confirm({
      title: 'Confirmación despublicar',
      content: 'La gauchada será despublicada',
      buttons: {
        Aceptar: function () {
            $.get("despublicarGauchada.php",{pID: pID, tiene: postulantes});
            cartelDespublicar(pID);
        },
        Cancelar: function(){}
      }
      });
}

function cartelDespublicar(pID){
  $.confirm({
              title: '',
              content: 'La gauchada ha sido despublicada',
              buttons: {
                Aceptar: function () {
                  volverAPublicacion(pID);
                }
              }
            });
}

function errorDespostular(){
	$.confirm({
              title: '',
              content: 'No puede despostularse de la gauchada porque ha sido seleccionado para realizarla',
              buttons: {
                Aceptar: function () {
                  volverAPublicacion(pID);
                }
              }
    });
}

function despostularse(pID){
	$.get("php/datosDelUsuario.php?datos=devolver", function(datosUsr){
		var usr = JSON.parse(datosUsr);
		var usrID = usr.ID;
		$.get("obtenerPostulanteSeleccionado.php",{pID: pID},function(datos){
			var seleccionado = JSON.parse(datos);
			if(seleccionado !== null){
				if (seleccionado.id == usrID){
					errorDespostular();
				}
			} else {
					$.confirm({
      					title: 'Confirmación despostularse',
      					content: 'Está por despostularse de la gauchada',
      					buttons: {
        					Aceptar: function () {
            					$.get("despostularseDeGauchada.php",{pID: pID, uID: usrID});
            					cargarPublicacion(pID);
        					},
        					Cancelar: function(){}
      						}
      				});
				}
		//
      	//
      	});
	});
}

function acercaDe(){
  $.get("acercaDelSitio.php", {funcion: 'obtener'}, function(datos){
   var dato = JSON.parse(datos);
    $.dialog({
      columnClass: 'medium',
      keyboardEnabled: true,
      closeIcon: true,
      type: 'blue',
      title: '<h3>Acerca del sitio</h3>',
      content: '<p style="white-space: pre-wrap">'+dato.info+'</p>',
    });
  });
}

function modificarAcercaDe(){
  $.get("acercaDelSitio.php", {funcion: 'obtener'}, function(datos){
    var dato = JSON.parse(datos);
    $.confirm({
    columnClass: 'medium',
    title: 'Modificar información del sitio',
    content: '' +
    '<form action="acercaDelSitio.php?funcion=modificar" class="formulario" method="get">' +
    '<div class="form-group">' +
    '<label for="info">Información:</label><br/>' +
    '<textarea name="informacion" class="info" id="info" rows="10" cols="71"  maxlength="2000">' +dato.info+
    '</textarea>' +
    '</div>'+
    '<div class="errorInfo letraRoja"> </div>'+
    '</form>',
    buttons: {
        formSubmit: {
            text: 'Modificar',
            btnClass: 'btn-blue',
            action: function () {
                var info = this.$content.find('#info').val();
                var errorInfo = this.$content.find(".errorInfo");
                if(!info){
                  errorInfo.html('Debe completar el campo').slideDown(200);
                  return false;
                } else {
                  if (info == dato.info){
                    $.alert({
                      title:' ',
                      content: 'No se ha realizado ningún cambio'
                    });
                  } else {
                      errorInfo.hide();
                      $.get("acercaDelSitio.php", {funcion: 'modificar', info: info}, function(datosFinales){
                        $.alert({
                          columnClass: 'medium',
                          keyboardEnabled: true,
                          type: 'blue',
                          title: '<h4> La información se ha modificado correctamente. Así es como se visualizará:<h4>',
                          content: '<p style="white-space: pre-wrap">'+datosFinales+'</p>'
                        });
                      });
                  }
                }
                }
            },
        cancelar: function () {},
      },
  });
  });
}
