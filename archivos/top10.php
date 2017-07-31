<?php
	require("php/conexionBD.php");
  	conectarse($conexion);
  	session_start();
  	$sql = "SELECT `ID`,`Nombre`, `Apellido` FROM `usuarios` WHERE (`Administrador` = '0' AND `Bloqueada` = '0') ORDER BY `Apellido`, `Nombre` ";
  	$resultado = mysqli_query($conexion,$sql);
  	$rows = mysqli_num_rows($resultado);
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
	});

	function bloquearUsuario(uID, nombre, apellido){
		$.confirm({
      		title: 'Confirmación bloquear',
      		content: 'Está por bloquear a '+nombre+' '+apellido,
      		buttons: {
        		Aceptar: function () {
            		$.get("abUsuarios.php",{uID: uID, funcion: 'bloquear'}, function(datos){
            			cargarPagina('usuarios.php');
            		});
        			},
        		Cancelar: function(){}
      		}
      	});
	}
</script>
</head>
<body>
     <div class="container-fluid">
     <?php if($rows > 0){ ?>
		<div class="row fondoBlanco col-md-12">
			<div><h4>Usuarios activos: <?php echo "$rows" ?></h4></div>
			<?php while($usuarios = mysqli_fetch_row($resultado)){
				$u = $usuarios;
			?>
			<div class="row separar text-justify" style="margin-left: 1px; margin-right: 15px; border-width: 2px; border-color: #ECECEA; border-bottom-style: solid;">
				<div class="text-justify col-md-4">
						<?php echo "$u[2]"." "."$u[1]" ?>
				</div>
				<div class="col-md-6 text-center">
					<button type="button" class="btn btn-default" onclick="bloquearUsuario(<?php echo "'".$u[0]."'" ?>, <?php echo "'".$u[1]."'" ?>, <?php echo "'".$u[2]."'" ?>,)">Bloquear</button>
				</div>
			</div>
			<?php } ?>
		<?php }else{ ?>
				<div><h3>Usuarios activos: <?php echo "$rows" ?></h3> </div>
		<?php } ?>
		</div>
		</div>
</body>
</html>
