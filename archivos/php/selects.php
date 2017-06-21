<?php
require("conexionBD.php");
conectarse($conexion);
$arreglo= array();
$cont=0;
if ( isset($_GET["select"]) ) {
  if ( $_GET["select"]=="preguntas" ) {
    $sql = "SELECT `Pregunta` FROM `preguntas`";
  }elseif ( $_GET["select"]=="localidades" ) {
    $provNombre=$_GET["prov"];
    $sql2="SELECT `id` FROM `provincias` WHERE `provincia`='$provNombre'";
    $resultado=mysqli_query($conexion, $sql2);
    $fila = mysqli_fetch_row($resultado);
    $provID=$fila[0];
    $sql = "SELECT `localidad` FROM `localidades` WHERE `id_provincia`='$provID'";
  }elseif ( $_GET["select"]=="ciudad" ) {
    $ciuNombre=$_GET["ciu"];
    $sql2="SELECT `id_provincia` FROM `localidades` WHERE `localidad`='$ciuNombre'";
    $resultado=mysqli_query($conexion, $sql2);
    $fila = mysqli_fetch_row($resultado);
    $provID=$fila[0];
    $sql = "SELECT `localidad` FROM `localidades` WHERE `id_provincia`='$provID'";
    #provincia de la ciudad
    $sql2="SELECT `provincia` FROM `provincias` WHERE `id`='$provID'";
    $resultado=mysqli_query($conexion, $sql2);
    $fila = mysqli_fetch_row($resultado);
    $arreglo[0] = $fila[0];
    $cont=1;
  }elseif ( $_GET["select"]=="provincias" ) {
    $sql = "SELECT `provincia` FROM `provincias`";
  }else {
    $sql = "SELECT `Nombre` FROM `categorias`";
  }
  $result=mysqli_query($conexion, $sql);
  if ($result) {
    while ($row = mysqli_fetch_row($result)) {
      $arreglo[$cont] = $row[0];
      $cont=$cont+1;
    }
  } else {
    $arreglo[0] ="Error SQL";
  }
}else {
  $arreglo[0] ='Error GET vacio';
}
$jDatos = json_encode($arreglo);
echo $jDatos;
?>
