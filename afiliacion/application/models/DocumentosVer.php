
<?php
       
include ('../../../inc/config.inc.php');




$idDoc = $_POST["iddoc"];

//echo $idDoc;

$sQuery = "call afiliacion.SP_DOCUMENTO_RUTA('$idDoc');";
//echo $sQuery;
$resuldoc = $WBD->query($sQuery);

$DATS  = mysqli_fetch_array($resuldoc);
$ruta     =    $DATS['ruta'];
$rutadoc = json_encode(array("ruta" => $ruta));   

echo $rutadoc;


?>
 
