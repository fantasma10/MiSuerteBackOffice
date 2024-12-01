<?php
       
include ('../../../inc/config.inc.php');


$strBuscar = (!empty($_POST['strBuscar']))? trim($_POST['strBuscar']) : '';


$sQuery = "CALL `redefectiva`.`SP_FIND_CADENAS`('$strBuscar');";
$resulcadenas = $RBD->query($sQuery);
while($DATS  = mysqli_fetch_array($resulcadenas)){
     $data[] = array(    

              
              	"id"				    => $DATS['idCadena'],
					"label"				=> utf8_encode($DATS['nombreCadena']),
					"value" 			=> utf8_encode($DATS['nombreCadena']),
					"nIdCadena"		=> $DATS['idCadena'],
					"sNombreCadena"	    => utf8_encode($DATS['nombreCadena'])
              
          );

       
 }      


echo json_encode($data);

?>
 

