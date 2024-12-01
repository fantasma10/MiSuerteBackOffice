
<?php
        
//include ('../../inc/config.inc.php');



$htmlTipoContacto = '';

	$sQuery = "CALL `redefectiva`.`SP_LOAD_TIPOS_DE_CONTACTO`();";
$resultTipoContacto = $RBD->query( $sQuery );
 while($tipoContacto  = mysqli_fetch_array($resultTipoContacto)){
  $htmlTipoContacto .= '<option value="'.$tipoContacto['idTipoContacto'].'">'.utf8_encode($tipoContacto['descTipoContacto']).'</option>';
 }		

	  

?>
	