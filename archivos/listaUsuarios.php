<?php
	require("php/conexionBD.php");
  	conectarse($conexion);
  	session_start();

  	$sql = "SELECT `ID`,`Nombre`, `Apellido`, `Email` FROM `usuarios` WHERE (`Administrador` = '0' AND `Borrada` = '0') ORDER BY `Apellido`, `Nombre`";
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
</script>
</head>
<body>
     <div class="container-fluid">
     <?php if($rows > 0){ ?>
		<div class="row fondoBlanco col-md-12">
			<div><h4>Usuarios totales: <?php echo "$rows" ?></h4></div>
			<div class="row separar text-justify" style="margin-left: 1px; margin-right: 1px; color: white">
				<div class="col-md-4" style="background-color:#6DBDD6;">
					<div><strong>Apellido</strong></div>
				</div>
				<div class="col-md-4" style="background-color:#6DBDD6;">
					<div><b>Nombre</b></div>
				</div>
				<div class="col-md-4" style="background-color:#6DBDD6;">
					<div><strong>Email</strong></div>
				</div>
			</div>
			<?php while($usuarios = mysqli_fetch_row($resultado)){
				$u = $usuarios;
			?>
			<div class="row separar text-justify"> 
				<div class="text-justify" style="margin-left: 15px; margin-right: 15px; border-width: 2px; border-color: #ECECEA; border-bottom-style: solid;">
					<div class="col-md-4 text-justify"><?php echo "$u[2]" ?></div>
					<div class="col-md-4 text-justify"><?php echo "$u[1]" ?></div>
					<div class="col-md-4 text-justify"><?php echo "$u[3]" ?></div>
				</div>
			</div>
			<?php } ?>
		<?php }else{ ?>
				<div><h3>Usuarios totales: <?php echo "$rows" ?></h3> </div>
		<?php } ?>
		</div>
		</div>
</body>
</html>