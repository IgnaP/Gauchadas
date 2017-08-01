<?php
	require("php/conexionBD.php");
  	conectarse($conexion);
  	session_start();
  	$sql = "SELECT `Nombre`, `Apellido`,`Reputacion` FROM `usuarios` WHERE (`Administrador` = '0' AND `Bloqueada` = '0') ORDER BY `Reputacion` DESC";
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
				if( $u[2] > 0){
			  $cons="SELECT `Nombre` FROM `reputacion` WHERE `reputacion`.`vigente`= 0 AND `Puntos`<='$u[2]' ORDER BY `reputacion`.`Puntos`";
			  $result=mysqli_query($conexion,$cons);
			  $cant=mysqli_num_rows($result);
			  if ($cant == 1) {
			    $row=mysqli_fetch_row($result);
			    $rep=$row[0];
			  } else {
			    $cont=0;
			    while ($row=mysqli_fetch_row($result)) {
			      if (++$cont == $cant) {
			        $rep=$row[0];
			      }
			    }
			  }
			}else {
			  $cons="SELECT `Nombre` FROM `reputacion` WHERE `reputacion`.`vigente`= 0 AND `Puntos`>='$u[2]' ORDER BY `reputacion`.`Puntos`";
			  $result=mysqli_query($conexion,$cons);
			  $cant=mysqli_num_rows($result);
			  $row=mysqli_fetch_row($result);
			  $rep=$row[0];
			};
			?>
			<div class="row separar text-justify" style="margin-left: 1px; margin-right: 15px; border-width: 2px; border-color: #ECECEA; border-bottom-style: solid;">
				<div class="text-justify col-md-4">
						<?php echo "$u[1]"." "."$u[0]" ?>
				</div>
				<div class="col-md-3 text-center">
					<div > <h5> <?php echo $rep; ?> </h5> </div>
				</div>
				<div class="col-md-3 text-center">
					<div> <h5> <?php echo $u[2]; ?> </h5> </div>
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
