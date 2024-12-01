<?php
include ('../../../inc/config.inc.php');


//$cadbusq = $_POST['query'];
$strBuscar = (!empty($_POST['strBuscar']))? trim($_POST['strBuscar']) : '';
$arrayuno = '';

$sQuery = "CALL ".$_SESSION['db'].".`sp_select_emisores_ac`('$strBuscar');";
$resulcadenas = $WBD->query($sQuery);
while($DATS  = mysqli_fetch_array($resulcadenas)){
	
$idemisor      =    $DATS['nIdEmisor'];
$nombreemisor  =    $DATS['nombreEmisor'];
               
          $data[] = array(    

              
              	    "id"				=> $DATS['nIdEmisor'],
					"label"				=> utf8_encode($DATS['nombreEmisor']),
					"value" 			=> utf8_encode($DATS['nombreEmisor']),
					"nIdEmisor"		=> $DATS['nIdEmisor'],
					"snombreemisor"	    => utf8_encode($DATS['nombreEmisor']),
					"sRFC"				=> utf8_encode($DATS['sRFC']),
					"sNombreComercial"	=> utf8_encode($DATS['sNombreComercial'])
              
          );

       
 }      

echo json_encode($data);
  
?>