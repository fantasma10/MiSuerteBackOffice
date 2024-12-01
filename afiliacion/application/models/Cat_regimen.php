<?php
        
//include ('../../inc/config.inc.php');


$htmlRegimen = '';
	
	$sQuery = "CALL `redefectiva`.`SP_REGIMEN_CARGAR_LISTA`();";
$resultRegimen = $RBD->query( $sQuery );
 while($regimen  = mysqli_fetch_array($resultRegimen)){
   $htmlRegimen .= '<option value="'.$regimen['idRegimen'].'">'.utf8_encode($regimen['nombreRegimen']).'</option>';
 }
	   


         /*$resultRegimen = mysqli_query($rconn,"CALL `redefectiva`.`SP_REGIMEN_CARGAR_LISTA`()");
            while($regimen  = mysqli_fetch_array($resultRegimen,MYSQLI_ASSOC)){
             $htmlRegimen .= '<option value="'.$regimen['idRegimen'].'">'.utf8_encode($regimen['nombreRegimen']).'</option>';
             }

mysqli_close($rconn);*/


?>