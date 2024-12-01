<?php
include ('../../../inc/config.inc.php');


//$cadbusq = $_POST['query'];
$strBuscar = (!empty($_POST['strBuscar']))? trim($_POST['strBuscar']) : '';
$arrayuno = '';

$sQuery = "CALL `afiliacion`.`SP_SELECT_CLIENTESEQUIPO`('$strBuscar');";
$resulcadenas = $WBD->query($sQuery);
while($DATS  = mysqli_fetch_array($resulcadenas)){
	
	$idcadena      =    $DATS['cte'];
$nombrecadena  =    $DATS['sRazonSocial'];
               
          $data[] = array(    

              
              	"id"				    => $DATS['cte'],
					"label"				=> utf8_encode($DATS['sRazonSocial']),
					"value" 			=> utf8_encode($DATS['sRazonSocial']),
					"nIdCliente"		=> $DATS['cte'],
					"sRazonSocial"	    => utf8_encode($DATS['sRazonSocial'])
              
          );

       
 }      


echo json_encode($data);
 
?>
