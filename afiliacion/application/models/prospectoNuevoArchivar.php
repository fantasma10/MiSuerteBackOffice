
<?php
 
include ('../../../inc/config.inc.php');

$incrId = $_POST['incr'];//4
$sQuery = "CALL afiliacion.SP_DATMODCERO_ARCHIVAR($incrId);";
$result = $WBD->query($sQuery);
$DATS  = mysqli_fetch_array($result);
              
$rows = $DATS['rows'];

 $json = json_encode(array("rows"=>"$rows"));   

echo $json;
//mysqli_close($conn);
?>
 