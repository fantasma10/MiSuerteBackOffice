<?php
        
include ('../../../inc/config.inc.php');

$idprveedor= $_POST['idprov'];

$sQuery = "CALL redefectiva.SP_SELECT_PROVEEDOR_PORID('$idprveedor');";

//echo $sQuery;
$result = $WBD->query( $sQuery );
$data  = mysqli_fetch_array($result);

$idproov         =    $data['idProveedor'];
$rfc         =    $data['RFC'];
$tel         =    $data['telefono'];
$nomprov      =    $data['nombreProveedor'];
$racsoc      =    $data['razonSocial'];

$numcta     =    $data['numCuenta'];

$idstatproov          =    $data['idEstatusProveedor'];
$idtiproov          =    $data['idTipoProveedor'];



echo json_encode(array("idprov"   =>  "$idproov",
                       "rfc"      =>  "$rfc",
                       "tel"      =>  "$tel",
                       "nombre"   =>  "$nomprov",
                       "racsoc"   =>  "$racsoc",
                       "cta"      =>  "$numcta",
                       "status"   =>  "$idstatproov",
                       "tipo"     =>  "$idtiproov"
                      
                      
                      ));

?>