<?php
	require("conexionBD.php");
  	conectarse($conexion);
	if (!isset( $_GET["id"] )){
		header("Location: sesion.php"); //si intenta ingresar a esta pagina lo manda al inicio
	}
		$publicacion = $_GET["id"];
  		$sql = "SELECT usuarioID FROM postulantes WHERE publicacionID = '$publicacion'";
  		$result = mysqli_query($conexion, $sql);
  		$num_filas=mysqli_num_rows($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/estilos.css">
  <script>
  	function ejemplo(usrID){
  		alert(usrID);
  	}
  </script>
</head>
<body>
	<div class="container-fluid">
		<div class="row separar">
			<div class="col-md-2 col-md-offset-2">
				<button type="button" class="btn btn-default" onclick="cargarPublicacion(<?php echo $publicacion; ?>)">Volver a la publicación</button>
			</div>
		</div>
		<div class="row">
			<div class="col-md-8 col-md-offset-2 transparente">
			<div>
				<h2 class="text-center">Postulantes</h2>
			</div>
			<div class="col-md-10 col-md-offset-1">
			<table class="table table-hover">
			<?php 
				if ($num_filas>0) {
					while ( $users = mysqli_fetch_row($result) ) {
					$sql = "SELECT Nombre FROM usuarios WHERE ID = '$users[0]'";
					$result2 = mysqli_query($conexion, $sql);
	  				$userName = mysqli_fetch_row($result2); 
			?>
				<tr class="info">
					<td> <?php echo "$userName[0]" ?> </td>
					<td class="text-right"><button type="button" class="btn btn-default" disabled onclick="ejemplo(<?php echo $users[0]; ?>)">Ver detalles</button></td>
					<td class="text-right"><button type="button" class="btn btn-default" disabled onclick="ejemplo(<?php echo $users[0]; ?>)">Seleccionar postulante</button></td>
				</tr>
			<?php
					}
				}else{
			?>
				<tr class="info">
					<td class="text-center">Aún no tiene postulantes</td>
				</tr>
			<?php
				}
				mysqli_free_result($result);
			?>
			</table>
			</div>
		</div>
		</div>
	</div>
	
</body>
</html>