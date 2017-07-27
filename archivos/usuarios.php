<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/estilos.css">
</head>
<script>
$(document).ready(function(){
	$.get("php/buscarCookie.php?nombre=bloqueado", function (resultado, status){
    	if (resultado!="false") {
    		$("#uTotales").removeClass('active');
    		$("#bloqueados").removeClass('active');
    		$("#home").removeClass('in active');
    		$("#uBloqueados").removeClass('in active');
    		$("#activos").addClass('active');
    		$("#uActivos").addClass('in active');
        	cambiarAlerta(true, "Se ha bloqueado al usuario correctamente");
        	setTimeout(function() {
        		$("#alertaForm").addClass('hidden');
        	}, 4000);
  		}
  	});
  	$.get("php/buscarCookie.php?nombre=desbloqueado", function (resultado, status){
  		if (resultado!="false") {
    		$("#uTotales").removeClass('active');
    		$("#activos").removeClass('active');
    		$("#home").removeClass('in active');
    		$("#uActivos").removeClass('in active');
    		$("#bloqueados").addClass('active');
    		$("#uBloqueados").addClass('in active');
        	cambiarAlerta(true, "Se ha desbloqueado al usuario correctamente");
        	setTimeout(function() {
        		$("#alertaForm").addClass('hidden');
        	}, 4000);
  		}
  	});
	$("#home").load("listaUsuarios.php");
	$("#uActivos").load("listaUsuariosActivos.php");
	$("#uBloqueados").load("listaUsuariosBloqueados.php");
});
</script>
<body>
	<div class="row">
		<div class="transparente col-md-6 col-md-offset-3">
    		<div><h2 class="text-center">Usuarios</h2></div>
    		<div class="alert col-md-10 col-md-offset-1 hidden text-center" id="alertaForm">
      			<button type="button" class="close" data-dismiss="alert">&times;</button>
     		 	<strong id="alertaTxt"></strong>
      		</div>
  			<ul class="nav nav-tabs info">
    			<li class="active" id="uTotales"><a data-toggle="tab" href="#home">Usuarios</a></li>
    			<li id="activos"><a data-toggle="tab" href="#uActivos">Usuarios activos</a></li>
    			<li id="bloqueados"><a data-toggle="tab" href="#uBloqueados">Usuarios bloqueados</a></li>
  			</ul>
  			<div class="tab-content fondoBlanco">
    			<div id="home" class="tab-pane fade in active">

    			</div>
    			<div id="uActivos" class="tab-pane fade">
      				
    			</div>
    			<div id="uBloqueados" class="tab-pane fade">
      				
    			</div>
  			</div>
		</div>
	</div>
</body>
</html>