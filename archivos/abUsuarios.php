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
	}elseif($funcion == "desbloquear"){
		$sql = "UPDATE `usuarios` SET `Bloqueada`=0 WHERE `ID`='$uID'";
		$resultado = mysqli_query($conexion,$sql);
		$fechaActual = date("Y-m-d");
		$sql= "SELECT `ID` FROM `publicaciones` LEFT JOIN `calificaciones` ON `publicaciones`.`ID`=`calificaciones`.`ID_publicacion` WHERE (`publicaciones`.`FechaLimite` > '$fechaActual' AND `calificaciones`.`ID_publicacion` IS NULL AND `publicaciones`.`usuario` = '$uID')";
		$result = mysqli_query($conexion,$sql);
		$rows = mysqli_num_rows($result);
		if($rows > 0){
			while ($publicaciones = mysqli_fetch_row($result)) {
				$p = $publicaciones;
				$query = "UPDATE `publicaciones` SET `Activa`=1 WHERE `ID`='$p[0]'";
				$result2 = mysqli_query($conexion,$query);
				mysqli_free_result($result2);
			}
		}
		$sql="SELECT `ID_postulacion` FROM `postulantes` WHERE (`postulantes`.`vigente`='1' AND `postulantes`.`usuarioID`='$uID')";
		$result3 = mysqli_query($conexion,$sql);
		$filas = mysqli_num_rows($result3);
		if($filas > 0){
			while ($postulaciones = mysqli_fetch_row($result3)) {
				$pos = $postulaciones;
				$query = "UPDATE `postulantes` SET `vigente`=0 WHERE `ID_postulacion`='$pos[0]'";
				$result2 = mysqli_query($conexion,$query);
				mysqli_free_result($result2);
			}
		}
		$desbloqueado = "t";
		setcookie('desbloqueado', $desbloqueado, time() + 3600, "/");
	}
?>