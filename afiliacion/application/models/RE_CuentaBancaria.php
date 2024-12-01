<?php
//include ('../../../inc/config.inc.php');

			$sQueryDatosBancarios      = "CALL afiliacion.SP_PROSPECTO_GUARDAR_MODBANCARIO('$prosRFC',$prosIdUsr,$bancIdBanco,$bancIdDocEdocta,'$bancCuenta','$bancClabe','$bancBenefi','$bancDescrip');";
			 $resultDatosBancarios = $WBD->query($sQueryDatosBancarios);
            $bancarios  = mysqli_fetch_array($resultDatosBancarios);


          // $records = json_encode(array("records" => $generales['cuenta']));

//printf("Error: %s\n", mysqli_error($conn));
//echo $records;
//mysqli_free_result($resultDatosGenerales);

//mysqli_close($conn);

?>
