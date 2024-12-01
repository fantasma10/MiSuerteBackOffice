<?php
        
include ('../../../inc/config.inc.php');

$idproducto= $_POST['idprod'];
$usaurio = $_POST['usr'];
$sQuery = "CALL redefectiva.SP_UPDATE_ELIMINAR_PRODUCTOS('$idproducto','$usaurio');";

//echo $sQuery;
$result = $WBD->query( $sQuery );
$data  = mysqli_fetch_array($result);
$code =    $data['code'];
$msg =    $data['msg'];

echo json_encode(array("code"=>"$code","msg"=>"$msg"));

?>