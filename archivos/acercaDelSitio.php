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
		}
	}
?>