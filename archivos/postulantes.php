<?php
	require("php/conexionBD.php");
  	conectarse($conexion);
	if (!isset( $_GET["id"] )){
		header("Location: sesion.php"); //si intenta ingresar a esta pagina lo manda al inicio
	}
		$publicacion = $_GET["id"];
  		$sql = "SELECT `usuarioID`, `comentario` FROM `postulantes` WHERE publicacionID = '$publicacion'";
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
  //$(document).ready(function(){
  //	$("#botoncito").on('click',function(){
  //		alert("hola!!");
 // 		$(this).remove();
  //	})
 // });
// $(document).ready(function(){
// 	$("#botoncito").on("click",probandojquery);
// });

 // $(document).ready(function(){
  //	$("#botoncito").on('click',function(){
  //		$.get()
  //	})

  //});
//   $(document).ready(function(){
// 	$("#botoncito").on("click",obtenerDatosConID("$publicacion", $userName[0]));
// });

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
			<table class="table fondoBlanco">
				<tr class="info">
					<th class="text-center">Nombre</th>
					<th class="text-center">Comentario</th>
					<th class="text-center">Detalle</th>
					<th class="text-center">Seleccionar</th>
				</tr>
			<?php
				if ($num_filas>0) {
					while ( $users = mysqli_fetch_row($result) ) {
					$sql = "SELECT Nombre FROM usuarios WHERE ID = '$users[0]'";
					$result2 = mysqli_query($conexion, $sql);
	  			$userName = mysqli_fetch_row($result2);

			?>
				<tr>
					<td> <?php echo "$userName[0]" ?> </td>
					<td><?php echo "$users[1]" ?></td>
					<?php $u = $users[0]; ?>
					<td class="text-center"><button type="button" class="btn btn-default" onclick="verDetallesPostulante(<?php echo $users[0]; ?>, <?php echo"'".$publicacion."'" ?>)">Ver detalles</button></td>
					<td class="text-center"><button type="button" class="btn btn-default" id="botoncito" onclick="obtenerDatosConID(<?php echo "'".$publicacion."'"?>, <?php echo "'".$users[0]."'" ?>, <?php echo "'".$userName[0]."'" ?>)">Seleccionar postulante</button></td>
				</tr>
			<?php
					}
				}else{
			?>
				<tr class="warning">
					<td colspan="4" class="text-center">Aún no tiene postulantes</td>
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
