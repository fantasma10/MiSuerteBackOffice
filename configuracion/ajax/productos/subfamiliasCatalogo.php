<?php
        
include ('../../../inc/config.inc.php');

$familia = $_POST['idfamilia'];

$mensaje= '';
$htmlsubfamilia = '<option value="-1">--</option>';
	
	$sQuery = "CALL `redefectiva`.`SP_LOAD_SUBFAMILIAS_POR_FAMILIA`('$familia');";
$resultRutas = $WBD->query( $sQuery );
 while($subfamilia  = mysqli_fetch_array($resultRutas)){
   $htmlsubfamilia .= '<option value="'.$subfamilia['idSubFamilia'].'">'.utf8_encode($subfamilia['descSubFamilia']).'</option>';
 }
	   
echo $htmlsubfamilia;

?>