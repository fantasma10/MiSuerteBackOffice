<?php
 
include ('../../../inc/config.inc.php');

$numCuenta = $_POST['cuenta'];

$sQuery = "CALL afiliacion.SP_VALIDAR_NUMERODECUENTA('$numCuenta');";

$resultcuenta = $WBD->query($sQuery);
$DATS  = mysqli_fetch_array($resultcuenta);
$cuenta = $DATS['cta'];

          $jsoncocta = json_encode(array(
              "codcta"=>"$cuenta" ));   
echo $jsoncocta;

//printf("Error: %s\n", mysqli_error($conn));
//mysqli_close($conn);
?>