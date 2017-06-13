<?php
	require("php/conexionBD.php");
  	conectarse($conexion);
	if (!isset( $_GET["id"] )){
		header("Location: sesion.php");
	}
		$uID = $_GET["id"];
	  	$sql = "SELECT `Nombre`,`Reputacion`, `Imagen` FROM `usuarios` WHERE `ID` = $uID";
	  	$result = mysqli_query($conexion, $sql);
  		$datos = mysqli_fetch_row($result);
  		$sql = "SELECT `Nombre` FROM `reputacion` WHERE `Puntos` = $datos[1]";
  		$result3 = mysqli_query($conexion,$sql);
  		$reputacion = mysqli_fetch_row($result3);
		$sql2 = "SELECT `calificacion`, `comentario`, `fecha` FROM `calificaciones` WHERE `ID_usuario` = $uID";
	  	$result2 = mysqli_query($conexion, $sql2);
  		$num_filas=mysqli_num_rows($result2);
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
	<div class="container">
		<div class="row separar text-center transparente">
			<div class="col-md-5 separar">
				<?php 
					if(!(is_null($datos[2]))){
						echo "<img src='/Gauchadas/imagenes/".$datos[2]."'>";
					}
				?>
				<h3><?php echo "$datos[0]" ?></h3>
				<h5><?php echo "$reputacion[0]" ?></h5>
				<button type="button" class="btn btn-default" disabled onclick="ejemplo(<?php echo $users[0]; ?>)">Seleccionar postulante</button>
			</div>
			<div class="col-md-7">
				<div class="text-align-left">
					<h3>Calificaciones</h3>
				</div>
			</div>
		<?php 
			if($num_filas>0){	
		?>
			<div class="info col-md-2"> Puntaje </div>
			<div class="info col-md-4"> Comentario </div>
			<?php
				while ($calificaciones = mysqli_fetch_row($result2)){
					$c = $calificaciones;	
			?>
				<div class="col-md-2 fondoBlanco">
		<?php echo "$c[0]"; 
		?>
				</div>
				<div class="col-md-4 fondoBlanco">
		<?php echo "$c[1]"; 
		?>
				</div>
		<?php
			}
		}else{
		?>
			<div class="warning"> sin calificaciones </div>
		<?php
			} 
		?>
		</div>
	</div>
</body>
</html>