function cargarPagina(pag){
  $("li").removeClass("active");
  $("#lacaja").load(pag);
}
function marcarPestaña(pest){
  $(pest).addClass("active");
}
function cargarProvincias(porDefecto){
  $('#provincias').html( $('<option>', {value: porDefecto, text: porDefecto}) );
  $.get("php/selects.php?select=provincias", function(datos){
    var jDatos= JSON.parse(datos);
    for (var x in jDatos) {
      $('#provincias').append($('<option>', {value: jDatos[x], text: jDatos[x]}));
    }
  });
}
function localidadesFuncion(porDefecto){
  $('#ciudades').html( $('<option>', {value: porDefecto, text: porDefecto}) );
  var seleccionado= $("#provincias").val();
  if ( (seleccionado!="Todas") && (seleccionado!='') ) {
    $("#ciudades").prop("disabled",false);
    $.get("php/selects.php?select=localidades&prov="+seleccionado, function(datos){
      var jDatos= JSON.parse(datos);
      for (var x in jDatos) {
        $('#ciudades').append($('<option>', {value: jDatos[x], text: jDatos[x]}));
      }
    });
  }else {
    $("#ciudades").prop("disabled",true);
  }
}
function cargarCategorias(porDefecto){
  $('#categorias').html( $('<option>', {value: porDefecto, text: porDefecto}) );
  $.get("php/selects.php?select=categorias", function(datos){
    var jDatos= JSON.parse(datos);
    for (var x in jDatos) {
      $('#categorias').append($('<option>', {value: jDatos[x], text: jDatos[x]}));
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
  obtener(pID, usrID, usrN, seleccionarPostulante);
}

function obtener(pID, usrID, usrN, seleccionarPostulante){
  $.get("obtenerPostulantes.php",{pID: pID, uID: usrID}, function(datos){
  var datosJ = JSON.parse(datos);
  $.confirm({
    title: 'Confirmación de postulante seleccionado',
    content: 'Está por seleccionar a <strong>'+usrN+'</strong> y rechazar a los siguientes postulantes: '+'<br/>'+'<br/>'+datosJ.join('<br/>'),
    buttons: {
        Aceptar: function () {
            seleccionarPostulante(usrN, pID, usrID);
        },
        cancelar: function () {    
      }
   }
  });
  });
}

function seleccionarPostulante(usrN, pID, usrID){
  $.get("php/datosDelUsuario.php?datos=devolver", function(datosU){
    var jDatos = JSON.parse(datosU);
    $.alert({
      title:'Envio de datos al postulante',
      content: 'Seleccionó al postulante <strong>'+usrN+'</strong> y se le enviará un correo con los siguientes datos personales: '+'<br/><br/>'
                +'Nombre: '+jDatos.nom+'<br/>'+'Email: '+jDatos.email,
    });
  $.get("modificarPorSeleccionado.php",{pID: pID, usrACalificar: usrID});
  // cargarPublicacion(pID);
  });
}

 function cargarPublicacion(pID){
     // $("li").removeClass("active");
     // $("#lacaja").load("publicacion.php",{"ID":pID});
    }