<?php
 //include ('../../../inc/config.inc.php');

			$sQueryDatosGenerales      = "CALL `afiliacion`.`SP_PROSPECTO_GUARDAR_MODDATOSGENERALES`('$prosRFC','$prosIdRegimen','$prosIdgiro','$prosIdEstatus','$prosTelef','$prosnIdSocio','$prosIdTipoForelo','$prosIdCadena','$prosIdCte','$dirIdDireccion','$prosIdEjec','$prosIdDocRFC','$prosIdDocDom','$prosMail','$prosNombre','$prosPaterno','$prosMaterno','$prosRaSoc','$prosComercial','$prosIdUsr','$confVersion');";

			 $resultDatosGenerales = $WBD->query($sQueryDatosGenerales);
            $generales  = mysqli_fetch_array($resultDatosGenerales);


          // $records = json_encode(array("records" => $generales['cuenta']));

//printf("Error: %s\n", mysqli_error($conn));
//echo $records;
//mysqli_free_result($resultDatosGenerales);

//mysqli_close($conn);


?>