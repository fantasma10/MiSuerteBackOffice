<?php
        
include ('../../../inc/config.inc.php');


$mensaje= '';
$htmlProveedor = '';
 $htmlProveedor .= '<option value="-1">--</option>';	
	$sQuery = "CALL `redefectiva`.`SP_SELECT_PROVEEDORES_CAT`();";
$resultProveedor = $WBD->query( $sQuery );
 while($proveedor  = mysqli_fetch_array($resultProveedor)){
   $htmlProveedor .= '<option value="'.$proveedor['idProveedor'].'">'.utf8_encode($proveedor['nombreProveedor']).'</option>';
 }
	   
echo $htmlProveedor;

?>