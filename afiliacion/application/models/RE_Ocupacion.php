<?php
        
//include ('../../inc/config.inc.php');


$htmlOcupacion = '';
	
	$sQueryocup = "CALL `redefectiva`.`SP_OCUPACION_LISTA`();";
$resultOcupacions = $RBD->query($sQueryocup);
 while($ocupacions  = mysqli_fetch_array($resultOcupacions)){
  $htmlOcupacion .= '<option value="'.$ocupacions['idOcupacion'].'">'.utf8_encode($ocupacions['ocupacion']).'</option>';
 }	


       
?>