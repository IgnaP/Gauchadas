<?php
function conectarse(&$conexion){
  $db_host="localhost";   //<- direccion de la base de datos
  $db_nombre="gauchadas";   //<- nombre de la base de datos
  $db_usuario="root";     //<- nombre del usuario
  $db_clave="";          //<- contraseña de la base datos. Por defecto esta vacia
  $conexion=mysqli_connect($db_host,$db_usuario,$db_clave,$db_nombre);
  mysqli_set_charset($conexion,"utf8_bin");
}
?>
