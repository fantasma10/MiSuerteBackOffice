<?php
        
include ('../../../inc/config.inc.php');


$rfc        = $_POST['rfc'];

$sQuery = "CALL `redefectiva`.`SP_SELECT_PROVEEDOR_RFC_VALIDAR`('$rfc');";

//echo $sQuery;
$result = $WBD->query( $sQuery );
$data  = mysqli_fetch_array($result);
  
$code =    $data['code'];
$msg =    $data['msg'];


echo json_encode(array("code"=>"$code","msg"=>"$msg"));

?>