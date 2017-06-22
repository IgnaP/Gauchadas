<?php
	require("php/conexionBD.php");
  	conectarse($conexion);
	if (!isset( $_GET["puntaje"]) & !isset( $_GET["comentario"]) & !isset( $_GET["uID"]) & !isset( $_GET["pID"]) ){
		echo "<script type='text/javascript'> alert ('Error al enviar los datos')</script>
						<script type='text/javascript'> window.location= 'sesion.php'</script>";
	} else {
		$puntaje = $_GET["puntaje"];
		$comentario = $_GET["comentario"];
		$usrID = $_GET["uID"];
		$publicacion = $_GET["pID"];

		$sql = "UPDATE `calificaciones` SET `calificacion` = '$puntaje', `comentario` = '$comentario' WHERE `ID_usuario` = '$usrID' AND `ID_publicacion` = '$publicacion'";
		$resultado = mysqli_query($conexion, $sql);

		if(($puntaje == 1) | ($puntaje == -1)){
			$sql = "SELECT `Reputacion`, `Creditos` FROM `usuarios` WHERE `ID` = $usrID";
			$result1 = mysqli_query($conexion, $sql);
			$datos = mysqli_fetch_row($result1);
			if($puntaje == 1){
				$reputacion = $datos[0]+1;
				$creditos = $datos[1]+1;
				$sql = "UPDATE `usuarios` SET `Reputacion`= $reputacion,`Creditos`= $creditos WHERE `ID` = '$usrID'";
				$result2 = mysqli_query($conexion, $sql);
			} else {
				$reputacion = $datos[0]-2;
				$sql = "UPDATE `usuarios` SET `Reputacion`= $reputacion WHERE `ID` = '$usrID'";
				$result2 = mysqli_query($conexion, $sql);
			}
		}
	}
?>