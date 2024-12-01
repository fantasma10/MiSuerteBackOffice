<?php
include ('../../../inc/config.inc.php');


//$cadbusq = $_POST['query'];
$strBuscar = (!empty($_POST['strBuscar']))? trim($_POST['strBuscar']) : '';
$arrayuno = '';

$sQuery = "CALL `redefectiva`.`SP_SELECT_CADENAS_AC`('$strBuscar');";
$resulcadenas = $WBD->query($sQuery);
while($DATS  = mysqli_fetch_array($resulcadenas)){
	
$idemisor      =    $DATS['idCadena'];
$nombreemisor  =    $DATS['nombrecadena'];
               
          $data[] = array(    

              
              	    "id"				=> $DATS['idCadena'],
					"label"				=> utf8_encode($DATS['nombrecadena']),
					"value" 			=> utf8_encode($DATS['nombrecadena']),
					"nIdCadena"		=> $DATS['idCadena'],
					"snombreCadena"	    => utf8_encode($DATS['nombrecadena'])
              
          );

       
 }      

echo json_encode($data);
 
?>