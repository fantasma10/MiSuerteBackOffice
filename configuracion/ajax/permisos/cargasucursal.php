<?php

include ('../../../inc/config.inc.php');

$idcliente = $_POST['cliente'];

//$arrayuno = '';

$htmlsucs = '<option value = "-1">--</option>';

$sQuery = "CALL `redefectiva`.`SP_SELECT_SUCURSALES_POR_CLIENTE`('$idcliente');";
$resulcadenas = $WBD->query($sQuery);
while($DATS  = mysqli_fetch_array($resulcadenas)){
	
$idsucursal      =    $DATS['idCorresponsal'];
$nombresucursal  =    utf8_encode($DATS['nombreCorresponsal']);
               
    
$htmlsucs .= '<option value = '.$idsucursal.'>'.$idsucursal.' '.$nombresucursal.'</option>';    
       /*   $data[] = array(    

              
              	    "idsuc"		=> $idsucursal,
					"nomsuc"	=> $nombresucursal
					
              
          );*/

       
 }      

//echo json_encode($data);
 echo $htmlsucs;

?>