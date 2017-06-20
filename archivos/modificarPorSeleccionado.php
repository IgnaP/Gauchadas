<?php
	require("php/conexionBD.php");
	conectarse($conexion);

	$publicacion = $_GET["pID"];
	$usr = $_GET["usrACalificar"];

	$sql = "UPDATE `publicaciones` SET `Activa`= 0 WHERE `ID` = '$publicacion'";
	$resultado = mysqli_query($conexion, $sql);

	$sql = "UPDATE `postulantes` SET `seleccionado`= 1 WHERE `publicacionID` = '$publicacion' AND `usuarioID` = '$usr'";
	$result2 = mysqli_query($conexion, $sql);

	$sql = "INSERT INTO `calificaciones`(`ID_usuario`, `ID_publicacion`) VALUES ('$usr', '$publicacion')";
	$result3 = mysqli_query($conexion, $sql);
?>