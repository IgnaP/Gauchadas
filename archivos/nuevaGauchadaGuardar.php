<?php
require("conexionBD.php");
conectarse($conexion);
if (!$conexion) {
  echo "Fallo al conectar con el servidor";
  exit();
} else {
  session_start();
  $email = $_SESSION["usuario"];
  $consulta="SELECT * FROM Usuarios WHERE Email='$email'";
  $resultado=mysqli_query($conexion,$consulta);
  $fila=mysqli_fetch_row($resultado);
  $creditos=$fila[13];
  if ($creditos>0) {
    $tit = $_POST["titulo"];
    $ciu = $_POST["ciudad"];
    $fec = $_POST["fecha"];
    $cat = $_POST["categoria"];
    $des = $_POST["descrip"];
    #$img = $_POST["imagen"];

    $sql="SELECT `ID` FROM `usuarios` WHERE `Email`='$email'";
    $result=mysqli_query($conexion,$sql);
    $row = mysqli_fetch_row($result);
    $usrID=$row[0];
    $sql="SELECT `ID` FROM `ciudades` WHERE `Nombre`='$ciu'";
    $result=mysqli_query($conexion,$sql);
    $row = mysqli_fetch_row($result);
    $ciuID=$row[0];
    $sql="SELECT `ID` FROM `categorias` WHERE `Nombre`='$cat'";
    $result=mysqli_query($conexion,$sql);
    $row = mysqli_fetch_row($result);
    $catID=$row[0];

    $sql="INSERT INTO `publicaciones`(`Nombre`, `Ciudad`, `FechaLimite`, `Categoria`, `Descripcion`, `usuario`)
                            VALUES ('$tit','$ciuID','$fec','$catID','$des','$usrID')";
    $resultado=mysqli_query($conexion,$sql);

    if($resultado==false){
      echo "Se produjo un error al intentar agregar la gauchada";
    } else {
      $creditos=$creditos-1;
      $sql="UPDATE `usuarios` SET `Creditos`='$creditos' WHERE `Email`='$email'";
      $resultado=mysqli_query($conexion,$sql);
      echo "exito";
    }
  } else {
    echo "Creditos insuficientes";
  }
}
?>
