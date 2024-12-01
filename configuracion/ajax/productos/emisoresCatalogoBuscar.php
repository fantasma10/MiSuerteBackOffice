<?php
include ('../../../inc/config.inc.php');


//$cadbusq = $_POST['query'];
$strBuscar = (!empty($_POST['strBuscar']))? trim($_POST['strBuscar']) : '';
$arrayuno = '';

$sQuery = "CALL `redefectiva`.`SP_SELECT_EMISORES_AC`('$strBuscar');";
$resulcadenas = $WBD->query($sQuery);
while($DATS  = mysqli_fetch_array($resulcadenas)){
	
$idemisor      =    $DATS['idEmisor'];
$nombreemisor  =    $DATS['nombre_emisor'];
               
          $data[] = array(    

              
              	    "id"				=> $DATS['idEmisor'],
					"label"				=> utf8_encode($DATS['nombre_emisor']),
					"value" 			=> utf8_encode($DATS['nombre_emisor']),
					"nIdCliente"		=> $DATS['idEmisor'],
					"sRazonSocial"	    => utf8_encode($DATS['nombre_emisor'])
              
          );

       
 }      

echo json_encode($data);
 
?>
