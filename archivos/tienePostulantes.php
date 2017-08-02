<?php
	require("php/conexionBD.php");
  	conectarse($conexion);

	$publicacion = $_GET["pID"];

	$sql = "SELECT `usuarioID` FROM `postulantes` WHERE publicacionID = '$publicacion'";
	$resultado = mysqli_query($conexion, $sql);
	$num_filas= mysqli_num_rows($resultado);

	if($num_filas >0){
		echo true;
	} else {
		echo false;
	}
?>