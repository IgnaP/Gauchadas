<?php
#require("conexionBD.php");
#conectarse($conexion);

$sql = "SELECT `Nombre` FROM `ciudades`";
if ($result=mysqli_query($conexion, $sql)) {
  while ($row = mysqli_fetch_row($result)) {
    echo "<option>" . $row[0] . "</option>";
  }
} else {
  echo "ERROR";
}
?>
