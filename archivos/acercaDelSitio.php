<?php
	require("php/conexionBD.php");
	conectarse($conexion);
	if(isset($_GET["funcion"])){
		$funcion = $_GET["funcion"];
		if ($funcion == "obtener"){
			$sql = "SELECT * FROM `informacion` WHERE `ID`='1'";
			$resultado = mysqli_query($conexion,$sql);
			$info = mysqli_fetch_row($resultado);
			$arreglo = array('info' => "$info[1]");
			$jDatos = json_encode($arreglo); //para que lo pueda entender javaScript
			echo $jDatos;
		} elseif ($funcion == "modificar" && isset($_GET["info"])){
			$info = $_GET["info"];
			$sql = "UPDATE `informacion` SET `informacion`='$info' WHERE `ID`='1'";
			$result = mysqli_query($conexion,$sql);
			echo $info;
		}
	}
?>