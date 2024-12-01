<?php
include ('../../../inc/config.inc.php');


$product = $_POST['prod'];

$htmlrutas = '<option value="-1">--</option>';


$sQuery = "CALL `redefectiva`.`SP_SELECT_RUTAS_POR_PRODUCTO`('$product');";
$resulcadenas = $WBD->query($sQuery);
while($DATS  = mysqli_fetch_array($resulcadenas)){
	
    $idruta         =    $DATS['idRuta'];
    $nombreemisor   =    utf8_encode($DATS['descRuta']);
    
    $htmlrutas .= '<option value="'.$idruta.'">'.$nombreemisor.'</option>';
    
 }      

echo $htmlrutas;
 
?>