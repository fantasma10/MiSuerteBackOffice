
<?php
 



$sQuery1 = "CALL afiliacion.SP_REPOSITORIO_GUARDAR('$nIdTipoDoc','$usuario','$file_name','$descript','$dir');";
$resultdocss = $WBD->query($sQuery1);
$DATSs  = mysqli_fetch_array($resultdocss);
$iddocumento = $DATSs['nIdDocumento'];

          

//printf("Error: %s\n", mysqli_error($conn));
//mysqli_close($conn);
?>
 

