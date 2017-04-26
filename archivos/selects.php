<?php
require("conexionBD.php");
conectarse($conexion);
if ( isset($_GET["select"]) ) {
  if ( $_GET["select"]=="preguntas" ) {
    $sql = "SELECT `Pregunta` FROM `preguntas`";
  }elseif ( $_GET["select"]=="ciudades" ) {
    $sql = "SELECT `Nombre` FROM `ciudades`";
  }else {
    $sql = "SELECT `Nombre` FROM `categorias`";
  }
  $result=mysqli_query($conexion, $sql);
  $cont=0;
  $arreglo= array();
  while ($row = mysqli_fetch_row($result)) {
    $arreglo[$cont] = $row[0];
    $cont=$cont+1;
  }
  $jDatos = json_encode($arreglo);
  echo $jDatos;
}
?>
