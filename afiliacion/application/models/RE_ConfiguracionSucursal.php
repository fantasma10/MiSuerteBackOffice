<?php
   

foreach ($confArrAccesos as $acesos){
//include ('../../../inc/config.inc.php');
$sQueryAccesos = "CALL `afiliacion`.`SP_SUCURSAL_GUARDAR_TIPOACCESO`('$identificador','$acesos','$idusuario')";
$resulAccesos = $WBD->query($sQueryAccesos);
$DATSaccess  = mysqli_fetch_array($resulAccesos);
//printf("Error: %s\n", mysqli_error($conn));
    
   $conteo = $DATSaccess['rowss'];
    
    $json = json_encode(array('registros'=> $conteo));
    //echo $json;
//mysqli_close($conn); 
}
?>
 

