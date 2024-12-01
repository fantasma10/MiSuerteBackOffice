
<?php
 
include ('../../../inc/config.inc.php');

$idsucursal = $_POST['idsuc'];
$sQuery = "CALL afiliacion.SP_SUCURSAL_VALIDAR('$idsucursal');";
$resultsucursal = $WBD->query($sQuery);
$DATS  = mysqli_fetch_array($resultsucursal);
$recordsaffected = $DATS['recs'];

          $json = json_encode(array(
              "recs"=>"$recordsaffected" ));   
echo $json;

//mysqli_close($conn);
?>
 