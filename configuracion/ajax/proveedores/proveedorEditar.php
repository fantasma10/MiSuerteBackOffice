<?php
        
include ('../../../inc/config.inc.php');


$idprov  = $_POST['idprov'];
$nombre  = utf8_encode($_POST['nombre']);
$rs      = utf8_encode($_POST['rs']);
$rfc     = $_POST['rfc'];
$tel     = $_POST['tel'];
$tipo    = $_POST['tipo'];
$usr     = $_POST['usr'];





	$sQuery = "CALL `redefectiva`.`SP_UPDATE_PROVEEDORID`('$idprov','$nombre','$rs','$rfc','$tel','$tipo','$usr');";

//echo $sQuery;
$result = $WBD->query( $sQuery );
$data  = mysqli_fetch_array($result);
  
$code =    $data['code'];
$msg =    $data['msg'];


echo json_encode(array("code"=>"$code","msg"=>"$msg"));

?>