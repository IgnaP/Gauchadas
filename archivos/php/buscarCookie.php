<?php
$nombre=$_GET["nombre"];
if ( isset($_COOKIE[$nombre]) ) {
  echo $_COOKIE[$nombre];
  setcookie($nombre, "", time()-10000, "/");
} else {
  echo "false";
}
?>
