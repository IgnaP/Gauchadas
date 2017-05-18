function cargarProvincias(porDefecto){
  $('#provincias').html( $('<option>', {value: porDefecto, text: porDefecto}) );
  $.get("selects.php?select=provincias", function(datos){
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
    $.get("selects.php?select=localidades&prov="+seleccionado, function(datos){
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
  $.get("selects.php?select=categorias", function(datos){
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
