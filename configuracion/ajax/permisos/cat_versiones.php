<?php
        
//include ('../../../inc/config.inc.php');


$htmlVersion = '';
	
	$sQuery = "CALL `redefectiva`.`SP_LOAD_VERSIONES`();";
$resultVersion = $WBD->query( $sQuery );
 while($version  = mysqli_fetch_array($resultVersion)){
   $htmlVersion .= '<option value="'.$version['idVersion'].'">'.utf8_encode($version['nombreVersion']).'</option>';
 }
	   


?>