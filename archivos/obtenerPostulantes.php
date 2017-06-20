<?php
	//Obtiene todos los postulantes menos el seleccionado
	require("php/conexionBD.php");
  	conectarse($conexion);

	$publicacion = $_GET["pID"];
	$usuario = $_GET["uID"];

	$sql = "SELECT `usuarioID` FROM `postulantes` WHERE publicacionID = '$publicacion' AND`usuarioID` <> '$usuario'";
	$result = mysqli_query($conexion, $sql);
	$num_filas= mysqli_num_rows($result);
	
	$array = array();
	if($num_filas >0){
		while ($usuarios = mysqli_fetch_row($result)) {
			$sql = "SELECT Nombre FROM usuarios WHERE ID = '$usuarios[0]'";
			$result2 = mysqli_query($conexion, $sql);
	  		$userName = mysqli_fetch_row($result2);
			array_push($array, $userName[0]);
		}
	}

	echo json_encode($array);
?>