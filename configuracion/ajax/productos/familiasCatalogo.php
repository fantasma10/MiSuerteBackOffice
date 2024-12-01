<?php
        
include ('../../../inc/config.inc.php');


$mensaje= '';
$htmlfamilias = '<option value="-1">--</option>';
	
	$sQuery = "CALL `redefectiva`.`SP_LOAD_FAMILIAS`();";
$result = $WBD->query( $sQuery );
 while($familias  = mysqli_fetch_array($result)){
   $htmlfamilias .= '<option value="'.$familias['idFamilia'].'">'.utf8_encode($familias['descFamilia']).'</option>';
 }
	   
echo $htmlfamilias;

?>