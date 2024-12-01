<?php
       
include ('../../../inc/config.inc.php');

$sQuery = "CALL `redefectiva`.`sp_select_areas`();";
$resultAreas = $RBD->query($sQuery);

while($DATS  = mysqli_fetch_array($resultAreas)){
    $data[] = array(         
        "nIdArea" => $DATS['nIdArea'],
        "sNombre" => utf8_encode($DATS['sNombre'])      
    ); 
}      

echo json_encode($data);

?>
 

