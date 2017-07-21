<?php
	require("php/conexionBD.php");
  	conectarse($conexion);
  	session_start();
  	$email = $_SESSION["usuario"];
  	$consulta = "SELECT `ID` FROM `usuarios` WHERE `Email`='$email'";
  	$resultado = mysqli_query($conexion,$consulta);
  	$fila = mysqli_fetch_row($resultado);
  	$id = $fila[0];
  	$sql = "SELECT `usuarios`.`Nombre`, `calificaciones`.`calificacion`, `calificaciones`.`comentario`
			FROM `usuarios`, `calificaciones`, `publicaciones`
			WHERE (`publicaciones`.`ID`=`calificaciones`.`ID_publicacion` AND `calificaciones`.`ID_usuario`='$id' AND `usuarios`.`ID`=`publicaciones`.`usuario` AND `calificaciones`.`comentario` IS NOT NULL)";
	$result = mysqli_query($conexion,$sql);
	$rows = mysqli_num_rows($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <link href="css/bootstrap.min.css" rel="stylesheet">
 <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
	<?php
		if($rows > 0){ ?>
		<div class="row separar text-justify" style="margin-left: 15px; margin-right: 15px; color: white">
			<div class="col-md-4" style="background-color:#6DBDD6;">
				<div><strong>Usuario que lo calificó</strong></div>
			</div>
			<div class="col-md-4" style="background-color:#6DBDD6;">
				<div><b>Puntaje</b></div>
			</div>
			<div class="col-md-4" style="background-color:#6DBDD6;">
				<div><strong>Comentario</strong></div>
			</div>
		</div>
		<?php while($calificaciones = mysqli_fetch_row($result)){
				$c = $calificaciones;
	?>
				<div class="row separar text-justify" style="margin-left: 15px; margin-right: 15px; border-width: 2px; border-color: #ECECEA; border-bottom-style: solid;"">
					<div class="col-md-4 text-justify">
						<?php echo "$c[0]" ?>
					</div>
					<div class="col-md-4 text-justify">
					<?php if($c[1] == -1){
							echo "Negativo";
						} else {
							if($c[1] == 1){
								echo "Positivo";
							} else {
								echo "Neutro";
							}
						} ?>
					</div>
					<div class="col-md-4 text-justify">
						<?php echo "$c[2]" ?>
					</div>
				</div>
		<?php		} ?>

		<?php } else { ?>
			<div class="separar text-center"><strong> No tiene calificaciones recibidas </strong></div>
	<?php	}
	?>
</body>
</html>