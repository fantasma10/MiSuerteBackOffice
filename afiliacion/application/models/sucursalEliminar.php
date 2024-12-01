
<?php
 
include ('../../../inc/config.inc.php');

$idsucursal = $_POST['idsuc'];

$sQuery = "CALL afiliacion.SP_SUCURSAL_ELIMINAR_SOLICITUD('$idsucursal');";

$resultsucursal = $WBD->query($sQuery);
$DATS  = mysqli_fetch_array($resultsucursal);
$recordsaffected = $DATS['NUM_SUCURSALES'];

          $json = json_encode(array(
              "recs"=>"$recordsaffected" ));   
echo $json;

//printf("Error: %s\n", mysqli_error($conn));
//mysqli_close($conn);
?>
 