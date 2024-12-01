<?php
include ('../../../inc/config.inc.php');


//$cadbusq = $_POST['query'];
$strBuscar = (!empty($_POST['strBuscar']))? trim($_POST['strBuscar']) : '';

$cadena = (!empty($_POST['cadenax']))? $_POST['cadenax'] : -1;


$arrayuno = '';

$sQuery = "CALL `redefectiva`.`SP_SELECT_CLIENTES_AC`('$strBuscar','$cadena');";

//echo $sQuery;
$resulcadenas = $WBD->query($sQuery);
while($DATS  = mysqli_fetch_array($resulcadenas)){
	
$idcte      =    $DATS['idCliente'];
$nombrcte  =    $DATS['nombreCliente'];
$idcad  =    $DATS['idCadena'];
$nombrecadena  =    $DATS['nombreCadena'];
               
          $data[] = array(    

              
              	    "id"				=> $DATS['idCliente'],
					"label"				=> utf8_encode($DATS['nombreCliente']),
					"value" 			=> utf8_encode($DATS['nombreCliente']),
					"nIdCliente"		=> $DATS['idCliente'],
					"sRazonSocial"	    => utf8_encode($DATS['nombreCliente']),
                    "nIdCadena"	        => $DATS['idCadena'],
                    "sCadNombre"	=> utf8_encode($DATS['nombreCadena']),
              
          );

       
 }      

echo json_encode($data);

?>