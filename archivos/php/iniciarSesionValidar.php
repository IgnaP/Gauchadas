<?php
require("conexionBD.php");
conectarse($conexion);
if (!$conexion) {
  echo "Fallo al conectar con el servidor";
} else {
  session_start();
  $email = $_POST["email"];
  $clave = $_POST["clave"];
  $consulta="SELECT * FROM Usuarios WHERE Email='$email'";
  $resultado=mysqli_query($conexion,$consulta);
  $num_filas=mysqli_num_rows($resultado);
  if ($num_filas!=0) {
    $fila=mysqli_fetch_row($resultado);
    if($fila[2]==$clave){
      if ($fila[10]=="0") {
        if ($fila[11]=="0") {
          $_SESSION["usuario"]=$email;
          if($fila[9]=="1"){
            echo "Admin";
            $_SESSION["tipo"]='Admin';
          } else {
            echo "Usuario";
            $_SESSION["tipo"]='Usuario';
          }
        } else {
          echo "La cuenta ha sido BORRADA";
        }
      } else {
        echo "La cuenta ha sido BLOQUEADA";
      }
    } else {
      echo "La clave es incorrecta";
    }
  } else {
    echo "El mail ingresado no existe";
  }
}
?>
