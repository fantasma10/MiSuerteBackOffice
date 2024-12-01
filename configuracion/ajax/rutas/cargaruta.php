<?php
        
include ('../../../inc/config.inc.php');


$idruta= $_POST['idruta'];

$sQuery = "CALL redefectiva.SPA_LOADRUTA('$idruta');";

//echo $sQuery;
$result = $WBD->query( $sQuery );
$data  = mysqli_fetch_array($result);

$idruta         =    $data['idRuta'];
$descruta       =    $data['descRuta'];

$idprod         =    $data['idProducto'];
$idprov         =    $data['idProveedor'];
$idconector     =    $data['idConector'];

$skuprov        =    $data['skuProveedor'];
$maxruta        =    $data['impMaxRuta'];
$minruta        =    $data['impMinRuta'];

$fevruta        =    $data['idFevRuta'];
$fsvruta        =    $data['idFsvRuta'];

$porcostoruta   =    $data['perCostoRuta'];
$impcostoruta   =    $data['impCostoRuta'];

$porcomprod     =    $data['perComisionProducto'];
$impcomprod     =    $data['impComisionProducto'];

$porcomusu      =    $data['perComCliente'];
$impcomusu      =    $data['impComCliente'];

$porcomcte      =    $data['perComCorresponsal'];
$impcomcte      =    $data['impComCorresponsal'];

$idestatus      =    $data['idEstatusRuta'];



echo json_encode(array("idurta"         =>  "$idruta",
                       "descruta"       =>  "$descruta",
                       
                       "idprod"         =>  "$idprod",
                       "idprov"         =>  "$idprov",
                       "idcon"          =>  "$idconector",
                       
                       "sku"            =>  "$skuprov",
                       "maxruta"        =>  "$maxruta",
                       "minruta"        =>  "$minruta",
                       
                       "fevruta"        =>  "$fevruta",
                       "fsvruta"        =>  "$fsvruta",
                       
                       "porcostoruta"   =>  "$porcostoruta",
                       "impcostoruta"   =>  "$impcostoruta",
                       
                       "porcomprod"     =>  "$porcomprod",
                       "impcomprod"     =>  "$impcomprod",
                       
                       "porcomusu"      =>  "$porcomusu",
                       "impcomusu"      =>  "$impcomusu",
                       
                       "porcomcte"      =>  "$porcomcte",
                       "impcomcte"      =>  "$impcomcte",
                       
                       "idestatus"      =>  "$idestatus"
                      
                      
                      ));

?>