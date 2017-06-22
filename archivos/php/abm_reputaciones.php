<?php
require("conexionBD.php");
conectarse($conexion);
if (!$conexion) {
  $respuesta="Fallo al conectar con el servidor";
} else {
  $funcion=$_POST['funcion'];
  $dato=$_POST['dato'];
  
}
 ?>
