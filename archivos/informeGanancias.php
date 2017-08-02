<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/estilos.css">
</head>
<script>

</script>
<body>
   <?php
   require("php/conexionBD.php");
   conectarse($conexion);
   $fI= $_POST["fecha1"];
   $fF=$_POST["fecha2"];

   // Transformo las fechas al formato año-mes-dia
   $fInicial= date("Y-m-d",strtotime($fI));
   $fFinal= date("Y-m-d", strtotime($fF));

   $sql="SELECT * FROM `compra_creditos` WHERE DATE(`compra_creditos`.`Fecha`) BETWEEN '$fInicial' AND '$fFinal' ORDER BY `Fecha`";
   $resultado=mysqli_query($conexion,$sql);
   $total=0;
   $rows= mysqli_num_rows($resultado);
   if($fFinal < $fInicial) { ?>
     <div class="text-center alert-danger alert col-md-8 col-md-offset-2">
       <h4> <b> La fecha de incio es superior a la fecha final. </b></h4>
     </div>
   <?php } elseif( $rows == 0 ) { ?>
     <div class="text-center alert-danger alert col-md-8 col-md-offset-2">
       <h4> <b>No hubo compra de creditos entre esos dias. </b></h4>
     </div>
      <?php } else { ?>
        <table class="table fondoBlanco ">
          <tr class="info">
            <th class="text-center">Nombre de usuario</th>
            <th class="text-center"> Fecha </th>
            <th class="text-center" > Cantidad de creditos </th>
            <th class= "text-center" > Precio de cada credito </th>
            <th class="text-center" > Total </th>
          </tr>
         <?php while($datos=mysqli_fetch_row($resultado)) {?>
      <tr class= "text-center" >
        <?php
        //Obtengo el nombre del usuario comprador.
        $consulta="SELECT `usuarios`.`Email` FROM `usuarios` WHERE `usuarios`.`ID`='$datos[1]'";
        $emailIncompleto=mysqli_query($conexion,$consulta);
        $email=mysqli_fetch_row($emailIncompleto);
        ?>
        <td> <?php echo $email[0]; ?> </td>
        <td> <?php echo $datos[4];?>  </td>
        <td class="text-center" > <?php echo $datos[3];?> </td>
        <?php
        //Obtengo el precio de los creditos.
        $consulta="SELECT `credito`.`Precio` FROM `credito` WHERE `Credito`.`ID_credito`='$datos[2]'";
        $precioConsulta = mysqli_query($conexion,$consulta);
        $precio= mysqli_fetch_row($precioConsulta);
        $subtotal=$precio[0] * $datos[3];
        $total=$total+$subtotal;?>
        <td class="text-center" > <?php echo $precio[0]; ?> </td>
        <td class="text-center "> <?php echo $subtotal; ?> </td>
      </tr>
<?php } ?>
      <tr class="success">
    <td class= "text-right" colspan="4"> <b>Total ganancia:</b></td>
    <td class="text-center" ><b> <?php echo $total; ?></b></td>
  </tr>
</table>
<?php } ?>
</body>
</html>
