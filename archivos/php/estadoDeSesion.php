<?php
  session_start();
  if (isset($_SESSION["usuario"])) {
    if($_SESSION["tipo"]=='Admin'){
      echo "Admin";
    }else{
      echo "Usuario";
    }
    }
   else{
    echo "false";
  }
?>
