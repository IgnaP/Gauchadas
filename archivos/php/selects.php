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
  }elseif ( $_GET["select"]=="provincias" ) {
    $sql = "SELECT `provincia` FROM `provincias`";
  }else {
    $sql = "SELECT `Nombre` FROM `categorias` WHERE `categorias`.`vigente`=1";
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
