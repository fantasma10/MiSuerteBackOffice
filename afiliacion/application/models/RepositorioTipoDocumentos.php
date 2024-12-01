
<?php
 

//include ('../../../inc/config.inc.php');

$sQuery = "CALL afiliacion.SP_CATALOGO_DOCUMENTO_LOAD('$nIdTipoDoc');"; 
$resultabrev = $WBD->query($sQuery);
$DATS  = mysqli_fetch_array($resultabrev);
$abreviatura = $DATS['sAbrevDoc'];

          

//printf("Error: %s\n", mysqli_error($conn));
//mysqli_close($rconn);
?>
 