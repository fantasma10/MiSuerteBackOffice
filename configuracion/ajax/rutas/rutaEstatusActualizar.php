<?php
        
include ('../../../inc/config.inc.php');

$idruta= $_POST['idrutas'];
$estatus = $_POST['idstatus'];
$usaurio = $_POST['usr'];

$sQuery = "CALL redefectiva.SP_UPDATE_RUTA_ESTATUS('$idruta','$estatus','$usaurio');";

//echo $sQuery;
$result = $WBD->query( $sQuery );
$data  = mysqli_fetch_array($result);
$code =    $data['code'];
$msg =    $data['msg'];

echo json_encode(array("code"=>"$code","msg"=>"$msg"));

?>