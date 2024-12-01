<?php
        
include ('../../../inc/config.inc.php');

$mensaje= '';
$htmlProducto = '';
 $htmlProducto .= '<option value="-1">--</option>';	
	$sQuery = "CALL `redefectiva`.`SP_SELECT_PRODUCTOS_CAT`();";
$resultProductos = $WBD->query( $sQuery );
 while($productos  = mysqli_fetch_array($resultProductos)){
   $htmlProducto .= '<option value="'.$productos['idProducto'].'">'.utf8_encode($productos['descProducto']).'</option>';
 }
	   
echo $htmlProducto;

?>