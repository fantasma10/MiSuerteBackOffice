<?php
        
include ('../../../inc/config.inc.php');

$idproducto= $_POST['idprodss'];
$estatus = $_POST['idstatus'];
$usaurio = $_POST['usr'];

$sQuery = "CALL redefectiva.SP_UPDATE_ELIMINAR_PRODUCTOS('$idproducto','$usaurio','$estatus');";

//echo $sQuery;
$result = $WBD->query( $sQuery );
$data  = mysqli_fetch_array($result);
$code =    $data['code'];
$msg =    $data['msg'];

echo json_encode(array("code"=>"$code","msg"=>"$msg"));

?>