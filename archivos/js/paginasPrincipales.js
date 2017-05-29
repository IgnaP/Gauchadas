function cargarPagina(pag){
  $("li").removeClass("active");
  $("#lacaja").load(pag);
}
function marcarPestaña(pest){
  $(pest).addClass("active");
}
