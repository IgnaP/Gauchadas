<?php	
	require("php/conexionBD.php");
  	conectarse($conexion);

  	$publicacion = $_GET["pID"];
  	$tiene = $_GET["tiene"];
  	$sql = "UPDATE `publicaciones` SET `Activa`= 0 WHERE `ID` = '$publicacion'";
  	$resultado = mysqli_query($conexion, $sql);
  	mysqli_free_result($resultado);

  	if($tiene == 0){
  		$sql = "SELECT `usuario` FROM `publicaciones` WHERE `ID` = '$publicacion'";
  		$result = mysqli_query($conexion, $sql);
  		$usr = mysqli_fetch_row($result);
  		$usuario = $usr[0];
  		$sql = "SELECT `Creditos` FROM `usuarios` WHERE `ID` = '$usuario'";
  		$result1 = mysqli_query($conexion, $sql);
  		$creditos = mysqli_fetch_row($result1);
  		$c = $creditos[0]+1;
  		mysqli_free_result($usr);
  		mysqli_free_result($result1);

  		$sql = "UPDATE `usuarios` SET `Creditos`= $c WHERE `ID` = '$usuario'";
  		$final = mysqli_query($conexion, $sql);

  	}
?>