<?php
   
//include ('../../../inc/config.inc.php');

/*$sQueryPerfil = "CALL `afiliacion`.`SP_PROSPECTO_GUARDAR_MODCONFIGURACION`('$prosRFC','$confPerfil','$prosIdUsr')";
$resulperfil = $WBD->query($sQueryPerfil);
$DATSper  = mysqli_fetch_array($resulperfil);

*/



$sQueryEliminaFamilias = "CALL `afiliacion`.`SP_PROSPECTO_ELIMINAR_FAMILIA`('$prosRFC',0)";
$resulborraFamilias = $WBD->query($sQueryEliminaFamilias);
$DATSper1  = mysqli_fetch_array($resulborraFamilias);


foreach ($confArrFamilias as $familias){

$sQueryFamilias = "CALL `afiliacion`.`SP_PROSPECTO_GUARDAR_FAMILIA`('$prosRFC','$familias',$prosIdUsr)";
$resulfamilias = $WBD->query($sQueryFamilias);
$DATSfam  = mysqli_fetch_array($resulfamilias);

}


$sQueryEliminaAccesos = "CALL `afiliacion`.`SP_PROSPECTO_ELIMINAR_TIPOACCESO`('$prosRFC',0)";
$resulborraAccesos = $WBD->query($sQueryEliminaAccesos);
$DATSper2  = mysqli_fetch_array($resulborraAccesos);


foreach ($confArrAccesos as $accesos){

$sQueryAccesos = "CALL `afiliacion`.`SP_PROSPECTO_GUARDAR_TIPOACCESO`('$prosRFC','$accesos','$prosIdUsr')";
$resulAccesos = $WBD->query($sQueryAccesos);
$DATSaccess  = mysqli_fetch_array($resulAccesos);
    
    
}


   //$conteo = $DATSaccess['cuentass'];
    
    //$json = json_encode(array('registros'=> $conteo));
    //echo $json;

?>
 

