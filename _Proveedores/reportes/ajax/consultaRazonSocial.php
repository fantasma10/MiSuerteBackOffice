<?php
include ('../../../inc/config.inc.php');

$strBuscar = (!empty($_POST['strBuscar']))? trim($_POST['strBuscar']) : '';
$arrayuno = '';

$sQuery = "CALL `redefectiva`.`sp_select_rfcrs_proveedor`('$strBuscar');";
$resulcadenas = $WBD->query($sQuery);
while($DATS  = mysqli_fetch_array($resulcadenas)){
	
$idemisor      =    $DATS['idProveedor'];
$nombreemisor  =    $DATS['nombreProveedor'];
               
          $data[] = array(    

              
              	    "id"				=> $DATS['idProveedor'],
					"label"				=> utf8_encode($DATS['nombreProveedor']),
					"value" 			=> utf8_encode($DATS['nombreProveedor']),
					"idProveedor"		=> $DATS['idProveedor'],
					"snombreproveedor"  => utf8_encode($DATS['nombreProveedor']),
					"RFC"				=> utf8_encode($DATS['RFC']),
					"nombreProveedor"	=> utf8_encode($DATS['nombreProveedor'])
              
          );

       
 }      

echo json_encode($data);
  
?>