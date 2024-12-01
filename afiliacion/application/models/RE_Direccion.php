<?php
//include ('../../../inc/config.inc.php');
	
			$sQueryDir      = "CALL `afiliacion`.`SP_PROSPECTO_REPLEGAL_GUARDAR_DIRECCION`('$prosRFC',$dirIdDRep, $dirIdDireccion,$dirIdEstatus,$prosIdUsr,$dirIdPais,$dirCP,$dirNIdEstado,$dirNumMunicipio,$dirNumColonia,$dirNumExt,'$dirNumInt','$dirCalle','$dirNombreEstado','$dirNombreMunicipio','$dirNombreColonia')";
        

            $resultDat = $WBD->query($sQueryDir);

            $direccionss  = mysqli_fetch_array($resultDat);


           //$records = json_encode(array("records" => $direccionss['cuenta']));

//printf("Error: %s\n", mysqli_error($conn));
//echo $records;


        //mysqli_close($conn);
		?>