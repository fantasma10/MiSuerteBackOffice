<?php


//include ('../../../inc/config.inc.php');

             

$sQueryRepsss = "CALL `afiliacion`.`SP_PROSPECTO_GUARDAR_MODREPLEGAL`('$prosRFC', '$repId','$repIdStatus','$repIdUsr','$repIdNacio','$repPolExpuesto','$repIdTipoID','$repIdOcup','$repIdDir','$repIdDocID','$repIdDocPoder','$repFecNac','$repNombre','$repPaterno','$repMaterno','$repNumId','$repRFC','$repCURP','$repTelef','$repMail');";

$resultRepsss = $WBD->query($sQueryRepsss);
$DATSperss  = mysqli_fetch_array($resultRepsss);


        


$sQueryRepDirss = "CALL `afiliacion`.`SP_PROSPECTO_GUARDAR_REPLEGALDIRECCION`('$prosRFC',$repId, $repIdDir,$repIdStatus,$prosIdUsr,$direpPais,$direpCP,$direpIdEdo,$direpNumMun,$direpNumCol,$direpNumExt,'$direpNumInt','$direpCalle','$direpNomEdo','$direpNomMun','$direpNomCol');";
$resultRepDirss = $WBD->query($sQueryRepDirss);
$DATSperDirss  = mysqli_fetch_array($resultRepDirss);
               

	?> 