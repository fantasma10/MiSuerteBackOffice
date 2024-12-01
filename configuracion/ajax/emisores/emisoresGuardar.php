<?php
        
include ('../../../inc/config.inc.php');

$idemisor   = $_POST['idemisor'];
$nombre     = utf8_encode($_POST['nombre']);
$abrev      = utf8_encode($_POST['abrev']);
$usr        = $_POST['usr'];
$estat      = $_POST['estat'];


	$sQuery = "CALL `redefectiva`.`SP_CREAR_EMISOR`('$idemisor','$nombre','$abrev','$usr','$estat');";

//echo $sQuery;
$result = $WBD->query( $sQuery );
$data  = mysqli_fetch_array($result);
  
$code =    $data['code'];
$msg =    $data['msg'];


echo json_encode(array("code"=>"$code","msg"=>"$msg"));

?>