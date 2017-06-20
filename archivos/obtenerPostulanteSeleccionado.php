<?php
	require("php/conexionBD.php");
  	conectarse($conexion);
	if (!isset( $_GET["pID"] )){
		header("Location: sesion.php"); //si intenta ingresar a esta pagina lo manda al inicio
	}

	$publicacion = $_GET["pID"];
	$sql = "SELECT `ID_usuario` FROM `calificaciones` WHERE `ID_publicacion` = '$publicacion' AND `calificacion` IS NULL";
	$resultado = mysqli_query($conexion,$sql);
	$num_filas = mysqli_num_rows($resultado);

	$usrSeleccionado = null;
	if($num_filas > 0){
		$usrSeleccionado = mysqli_fetch_row($resultado);
	}
	echo json_encode($usrSeleccionado);
?>