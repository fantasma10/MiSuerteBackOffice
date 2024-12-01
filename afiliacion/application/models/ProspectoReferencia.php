
<?php
       
include ('../../../inc/config.inc.php');
$RFC = $_POST['rfc'];

$sQuery = "call afiliacion.SP_REFERENCIABANCARIA_BUSCAR('$RFC');";
$resultpros = $WBD->query($sQuery);
$DATS  = mysqli_fetch_array($resultpros);
               
               
$mail           =    $DATS['sEmail'];
$razon          =    $DATS['sRazonSocial'];
$referencia     =    $DATS['sReferenciaBancaria'];


$datosJson = json_encode(array(
        "mail"=>"$mail",
        "razon"=>"$razon",
        "referencia"=>"$referencia"
));

echo $datosJson; 

//mysqli_close($rconn);
?>
 
