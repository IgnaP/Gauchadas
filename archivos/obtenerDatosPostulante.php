<?php
	require("php/conexionBD.php");
	conectarse($conexion);
	if(isset($_GET["ID"])){
		$id = $_GET["ID"];
		$sql = "SELECT `Email`, `Nombre`, `Telefono` FROM `usuarios` WHERE `ID` = '$id'";
		$result = mysqli_query($conexion,$sql);
		$usrN = mysqli_fetch_row($result);
		$datosPostulante = array('id' => "$id", 'nombre' => "$usrN[1]", 'email' => "$usrN[0]", 'tel' => "$usrN[2]");
	}
	else{
		$datosPostulante = null;
	}
	echo json_encode($datosPostulante);
?>