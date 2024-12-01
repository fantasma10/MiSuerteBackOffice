<?php
        
///include ('../../inc/config.inc.php');


$sQuery = "call afiliacion.SP_PROSPECTO_GUARDAR_MODLIQUIDACION('$prosRFC',
'$stat','$prosIdUsr','$tiporeembolso','$tipocomision','$tipoliquidacionreembolso','$tipoloquidacioncomsion')";


 $resultado = $WBD->query($sQuery);
    $gens  = mysqli_fetch_array($resultado);

 
  $conteo =   $gens['cuenta'];

  
?>

