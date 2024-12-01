<?php
        
include ('../../../inc/config.inc.php');

$producto = $_POST['prod'];
$rutaaa = $_POST['ruta'];
$mensaje= '';
$htmlRuta = '';
	
	$sQuery = "CALL `afiliacion`.`SP_SELECT_RUTAS_POR_PRODUCTO`('$producto','$rutaaa');";
$resultRutas = $WBD->query( $sQuery );
 while($rutas  = mysqli_fetch_array($resultRutas)){
   $htmlRuta .= '<option value="'.$rutas['idRuta'].'">'.utf8_encode($rutas['descruta']).'</option>';
 }
	   
echo $htmlRuta;

?>