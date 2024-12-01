
<?php

$RFCsss =  $_POST["RFC"];
$usuario = $_POST["usuario"];
       
include ('../../../inc/config.inc.php');
$sQuery1 = "CALL afiliacion.SP_PROSPECTO_VALIDAR('$RFCsss');";
$resultPais = $WBD->query($sQuery1);
$DATS  = mysqli_fetch_array($resultPais);
$cod = $DATS['cod'];
///$json = json_encode(array("cod"=>"$cod"));   
//printf("Error: %s\n", mysqli_error($conn));
//echo $json;
//mysqli_close($conn);
$hoy = date('ymd') ;
$sSeed = str_replace('-', '', $RFCsss);
$sSeed = $hoy.$sSeed;
$sSeed = substr($sSeed, 0, 13);


     
$sQuery = "call afiliacion.SP_CREAR_FORELO('$cuentabase','$RFCsss','$usuario');";

$resultcont = $WBD->query($sQuery);
$DATS  = mysqli_fetch_array($resultcont);

$referencia = $DATS['referencia'];
 

$sQuery3 = "CALL `afiliacion`.`SP_REFERENCIABANCARIA_GUARDAR`('$RFCsss', '$referencia', $usuario);";
$resultref = $WBD->query($sQuery3);

$DATSs  = mysqli_fetch_array($resultref);
$cods = $DATSs['SREFERENCIABANCARIA'];
$json = json_encode(array("cod"=>"$cods"));   

echo $json;




?>
 
