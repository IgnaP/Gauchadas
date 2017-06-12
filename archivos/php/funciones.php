<?php
function subirImagen(&$nombre_imagen,&$respuesta){
  $nombre_imagen=$_FILES["imagen"]["name"];
  $tipo_imagen=$_FILES["imagen"]["type"];
  if ($tipo_imagen=="image/jpg" || $tipo_imagen=="image/png" || $tipo_imagen=="image/jpeg") {
    $carpeta_destino='../imagenes/';
    move_uploaded_file($_FILES['imagen']['tmp_name'],$carpeta_destino.$nombre_imagen);
    return true;
  } else {
    $respuesta="Solo se pueden subir imagenes: jpg/jpeg/png";
    return false;
  }
}
?>
