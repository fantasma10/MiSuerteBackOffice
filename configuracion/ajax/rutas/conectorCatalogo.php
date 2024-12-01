<?php
        
include ('../../../inc/config.inc.php');



$mensaje= '';
$htmlconector = '';
 $htmlconector .= '<option value="-1">--</option>';		
	$sQuery = "CALL `redefectiva`.`SP_SELECT_CONECTORES_CAT`();";
$resultConectores = $WBD->query( $sQuery );
 while($conectores  = mysqli_fetch_array($resultConectores)){
   $htmlconector .= '<option value="'.$conectores['idConector'].'">'.utf8_encode($conectores['descConector']).'</option>';
 }
	   
echo $htmlconector;

?>