<?php
include ('../../../inc/config.inc.php');


//$cadbusq = $_POST['query'];
$strBuscar = (!empty($_POST['strBuscar']))? trim($_POST['strBuscar']) : '';
$arrayuno = '';

$sQuery = "CALL `redefectiva`.`SP_SELECT_PRODCTOS_AC`('$strBuscar');";
$resulcadenas = $WBD->query($sQuery);
while($DATS  = mysqli_fetch_array($resulcadenas)){
	
$idemisor      =    $DATS['idProducto'];
$nombreemisor  =    $DATS['nombreProducto'];
               
          $data[] = array(    

              
              	    "id"				=> $DATS['idProducto'],
					"label"				=> utf8_encode($DATS['nombreProducto']),
					"value" 			=> utf8_encode($DATS['nombreProducto']),
					"nIdCliente"		=> $DATS['idProducto'],
					"sRazonSocial"	    => utf8_encode($DATS['nombreProducto'])
              
          );

       
 }      

echo json_encode($data);
 
?>
