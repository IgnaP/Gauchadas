<?php
	//Obtiene ID del usuario seleccionado y su nombre
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
		$usrID = mysqli_fetch_row($resultado);
		$sql = "SELECT `Nombre` FROM `usuarios` WHERE `ID` = '$usrID[0]'";
		$result2 = mysqli_query($conexion,$sql);
		$usrN = mysqli_fetch_row($result2);
		$usrSeleccionado = array('id' => "$usrID[0]", 'nombre' => "$usrN[0]");
	}
	echo json_encode($usrSeleccionado);
?>