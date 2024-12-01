
<?php
 
//include ('../../../inc/config.inc.php');

$sQuery1 = "CALL afiliacion.SP_SUCURSAL_GUARDAR_DIRECCION('$idsucursal','$iddireccion','$idestatusdir', '$idusuario','$idpais','$latitud','$logitud','$codpost','$idestado','$numciudad','$numcolonia','$numexterno','$numinterno','$calle', '$nomestado','$nommunicip','$nomcolonia');";
$resultsucursalDir = $WBD->query($sQuery1);
$DATS  = mysqli_fetch_array($resultsucursalDir);
 
               
$recordsaffected = $DATS['rowss'];

          $json = json_encode(array(
              "registros"=>"$recordsaffected" ));   

echo $json;

//printf("Error: %s\n", mysqli_error($conn));
//mysqli_close($conn);
?>
 