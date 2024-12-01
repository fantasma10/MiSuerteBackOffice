
<?php
       
include ('../../../inc/config.inc.php');;
$incr = $_POST['incr'];
$sQuery = "call afiliacion.SP_PROSPECTO_CARGARMODCERO($incr);";
$resultpros =  $WBD->query($sQuery);
$DATS  = mysqli_fetch_array($resultpros);
               
               
$idincr     =    $DATS['nIdIncremental'];
$rfc        =    $DATS['sRFC'];
$pais       =    $DATS['nIdPais'];
$regimen    =    $DATS['nIdRegimen'];

$datosJson = json_encode(array(
        "incremental"=>"$idincr",
        "rfc"=>"$rfc",
        "idpais"=>"$pais",
        "idregimen"=>"$regimen"
));

echo $datosJson;

//mysqli_close($rconn);
?>
 
