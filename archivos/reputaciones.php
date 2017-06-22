<?php
require("php/conexionBD.php");
conectarse($conexion);
mysqli_query($conexion, "SET NAMES 'utf8'");
$sql="SELECT * FROM `reputacion` WHERE `vigente`=0";
$resultado=mysqli_query($conexion,$sql);
if(!$resultado){
  echo 'No se pudo realizar la consulta:'.mysql_error();
};
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/estilos.css">

<script>
$(".btn").click(function () {
var myDNI = $(this).data('id');
$(".modal-body #repu").text( myDNI);

});
</script>
</head>
<body>
  <div class="row">
  <div>
      <h2 class="text-center">Reputaciones</h2>
    </div>
    <div class="col-md-10 col-md-offset-1">
  <table class="table fondoBlanco">
    <tr class="info">
      <th class="text-center">Reputacion</th>
      <th class="text-center">Puntaje</th>
      <th class="text-center" colspan="4"> Opciones </th>
    </tr>
    <?php
      while($datos=mysqli_fetch_row($resultado)){?>
      <tr class= "text-center" >
        <td> <?php echo $datos[1]; ?> </td>
        <td> <?php
                  if($datos[2] < 0){
                    echo 'Menor a ',$datos[2];}
                    else {
                      echo '+', $datos[2];
                    }?>  </td>

                    <td class="text-center" ><button type="button" class="btn btn-default"> Modificar</button></td>
                    <td> <a href= "#eliminar" class="btn btn-default" data-id="<?php echo $datos[1]; ?>" data-toggle="modal"> Eliminar </a></td>
                  </tr>
<?php } ?>
      <tr>
    <td class= "text-center" colspan="4"><button type="button" class="btn btn-primary " >Crear una reputacion</button></td>
  </tr>
</table>
</div>
</div>
<div id="eliminar" class="modal fade">
  <div class="modal-dialog">
    <form class="modal-content" action="php/abm_reputaciones.php" method="POST">
    <div class="modal-header">
      <button tyle="button" class="close" data-dismiss="modal" aria-hidden="true">Cerrar</button>
      <h4 class="modal-title"> Confirmar eliminacion </h4>
    </div>
    <div class="modal-body">
      <p>Usted eliminara la siguiente reputacion:<h5 id="repu" name="repu" > </h5> </p>
      <input type="hidden" id="funcion" name="funcion" value="eliminar"/>
      <input type="hidden" id="dato" name="dato" value=""/>
    </div>
    <div class="modal-footer">
            <button type="submit" class="btn btn-primary" >Confirmar</button>
            </div>
</form>
</div>
</div>
</body>
</html>
