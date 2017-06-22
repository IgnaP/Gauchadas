<?php
	//Obtiene ID del usuario seleccionado y su nombre
	require("php/conexionBD.php");
  	conectarse($conexion);
	if (!isset( $_GET["pID"] )){
		header("Location: sesion.php"); //si intenta ingresar a esta pagina lo manda al inicio
	}

	$publicacion = $_GET["pID"];
	$sql = "SELECT `comentario`,`ID_usuario` FROM `calificaciones` WHERE `ID_publicacion` = '$publicacion'";
	$resultado = mysqli_query($conexion,$sql);
	$num_filas = mysqli_num_rows($resultado);

	if($num_filas > 0){
		$datos = mysqli_fetch_row($resultado);
		if(is_null($datos[0])){
			$debe = true;
		} else {
			$debe = false;
		}
	} else {
		$debe = false;
	}
	echo json_encode($debe);
?>