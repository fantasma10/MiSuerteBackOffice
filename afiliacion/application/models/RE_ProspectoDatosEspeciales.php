<?php
//include ('../../../inc/config.inc.php');

			$sQueryDatosEspeciales      = "CALL afiliacion.SP_PROSPECTO_GUARDAR_MODINFORMACIONESPECIAL('$prosRFC','$prosIdRegimen','$espIdStatus','$espIDTipoId','$espIdPaisNac','$espIdNacio','$espPolExpuesto','$espFechNaci','$espCURP','$espNumId','$espIdTipoSoc','$espIdDocActa','$espFechaConst','$prosRaSoc');";
			 $resultDatosEspeciales = $WBD->query($sQueryDatosEspeciales);
            $generales  = mysqli_fetch_array($resultDatosEspeciales);


          // $records = json_encode(array("records" => $generales['cuenta']));

//printf("Error: %s\n", mysqli_error($conn));
//echo $records;
//mysqli_free_result($resultDatosGenerales);

//mysqli_close($conn);

?>