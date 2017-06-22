<?php
$nombre=$_GET["nombre"];
$valor=$_GET["valor"];
setcookie($nombre,$valor, time() + 3600, "/");
?>
