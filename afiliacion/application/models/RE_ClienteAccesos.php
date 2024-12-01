<?php
       
include ('../../../inc/config.inc.php');
$rfc = $_POST['idcte'];

$sQuery = "CALL `afiliacion`.`SP_CLIENTE_ACCESOS`('$rfc');";

$resultaccesos = $WBD->query($sQuery);
$DATS  = mysqli_fetch_array($resultaccesos);
               
               
$access      =    $DATS['accesos'];
$famis      =    $DATS['fams'];

$json = json_encode(array("accesos" => $access,"fams" => $famis));

echo  $json;

//mysqli_close($rconn);
?>
 

