<?php
 
include ('../../../inc/config.inc.php');

$IdNum = $_POST['idnum'];

$sQuery = "CALL afiliacion.SP_VALIDAR_REPRESENTANTELEGAL('$IdNum');";
$resultcuenta = $WBD->query($sQuery);
$DATS  = mysqli_fetch_array($resultcuenta);

$codid = $DATS['codeid'];
$jsoncds = json_encode(array( "codid"=>"$codid" ));   
echo $jsoncds;

?>