<?php
	require("php/conexionBD.php");
  	conectarse($conexion);
	if(isset($_GET["pID"]) && isset($_GET["uID"])){
		$publicacion = $_GET["pID"];
		$usuario = $_GET["uID"];
		$sql="DELETE FROM `postulantes` WHERE (`publicacionID` = '$publicacion' AND `usuarioID` = '$usuario')";
		$result = mysqli_query($conexion,$sql);
	}
?>