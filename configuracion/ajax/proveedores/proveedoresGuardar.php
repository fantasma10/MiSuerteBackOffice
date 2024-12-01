<?php
        
include ('../../../inc/config.inc.php');


$nombre     = utf8_encode($_POST['nombre']);
$rs         = utf8_encode($_POST['rs']);
$rfc        = $_POST['rfc'];
$telfono    = $_POST['tel'];
$tipo       = $_POST['tipo'];
$usr        = $_POST['usr'];


//datos bancarios

/*$clabe        = $_POST['clabe'];
$banco        = $_POST['banco'];
$cuenta       = $_POST['cuenta'];
$benef        = $_POST['benef'];
$desc        = $_POST['desc'];*/





	$sQuery = "CALL `redefectiva`.`SP_CREAR_PROVEEDOR`('$nombre','$rs','$rfc','$telfono','$tipo','$usr');";

//echo $sQuery;
$result = $WBD->query( $sQuery );
$data  = mysqli_fetch_array($result);
  
$code =    $data['code'];
$msg =    $data['msg'];


echo json_encode(array("code"=>"$code","msg"=>"$msg"));

?>