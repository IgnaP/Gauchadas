<?php
	require("php/conexionBD.php");
	conectarse($conexion);
	$uID = $_GET["uID"];
	$funcion = $_GET["funcion"];
	if($funcion == "bloquear"){
		$sql = "UPDATE `usuarios` SET `Bloqueada`=1 WHERE `ID`='$uID'";
		$resultado = mysqli_query($conexion,$sql);
		$sql = "SELECT `ID` FROM `publicaciones` WHERE `usuario`='$uID' AND `Activa`='1'";
		$resultado2 = mysqli_query($conexion,$sql);
		$filas = mysqli_num_rows($resultado2);
		if($filas > 0){
			while($publicaciones = mysqli_fetch_row($resultado2)){
				$p = $publicaciones;
				$query = "UPDATE `publicaciones` SET `Activa`=0 WHERE `ID`='$p[0]'";
				$result = mysqli_query($conexion,$query);
				mysqli_free_result($result);
			}
		}
		$sql = "SELECT `ID_postulacion`, `publicacionID`, `usuarioID` FROM `postulantes` INNER JOIN `publicaciones` ON `postulantes`.`publicacionID` = `publicaciones`.`ID` WHERE (`publicaciones`.`Activa`=1 AND `postulantes`.`usuarioID`='$uID')";
		$resultado3 = mysqli_query($conexion,$sql);
		$cantFilas = mysqli_num_rows($resultado3);
		if($cantFilas > 0){
			while ($postulaciones = mysqli_fetch_row($resultado3)){
				$pos = $postulaciones;
				$query = "UPDATE `postulantes` SET `vigente`=1 WHERE `ID_postulacion`='$pos[0]'";
				$result2 = mysqli_query($conexion,$query);
				mysqli_free_result($result2);
			}
		}
		$bloqueado = "t";
		setcookie('bloqueado', $bloqueado, time() + 3600, "/");
	} //elseif(){

	//}
?>