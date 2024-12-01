<?php
        
//include ('../../inc/config.inc.php');


$htmlproductos = '';
	
	$sQuery = "CALL `afiliacion`.`SP_SELECT_PRODUCTOS`();";
$resultProducto = $WBD->query( $sQuery );
 while($producto  = mysqli_fetch_array($resultProducto)){
   $htmlproductos .= '<option value="'.$producto['idProducto'].'">'.utf8_encode($producto['descripcion']).'</option>';
 }
	   

//esta se agregara  al controlador de catalogos
?>