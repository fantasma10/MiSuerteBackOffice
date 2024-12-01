<?php

            
//include ('../../inc/config.inc.php');

$htmlgiro = '';

$sQuery = "CALL `redefectiva`.`SP_LOAD_GIROS`();";
$resultgiro = $RBD->query( $sQuery );
 while($giro  = mysqli_fetch_array($resultgiro)){
             $htmlgiro .= '<option value="'.$giro['idGiro'].'">'.utf8_encode($giro['descGiro']).'</option>';
 }
	        /*$resultgiro = mysqli_query($conn,"CALL `redefectiva`.`SP_LOAD_GIROS`()");
            while($giro  = mysqli_fetch_array($resultgiro,MYSQLI_ASSOC)){
             $htmlgiro .= '<option value="'.$giro['idGiro'].'">'.utf8_encode($giro['descGiro']).'</option>';
             }*/



//mysqli_close($rconn);

	
?>