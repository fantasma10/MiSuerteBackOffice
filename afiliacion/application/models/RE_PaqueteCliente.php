

	
<?php
//include ('../../../inc/config.inc.php');
	
			$sQueryPaq   = "CALL `afiliacion`.`SP_PROSPECTO_GUARDAR_MODPAQUETECOMERCIAL`('$prosRFC','$paqIdPaq','$prosIdUsr','$paqInsc','$paqAfil','$paqRentMens','$paqAnual','$paqProm','$paqLimSuc','$paqSuc','$paqPriori','$paqFecIni','$paqFecVenc');";
            
            $resultPaq = $WBD->query($sQueryPaq);

            $direccionss  = mysqli_fetch_array($resultPaq);


         $records = json_encode(array("records" => $direccionss['cuentass']));

//printf("Error: %s\n", mysqli_error($conn));
echo $records;


       // mysqli_close($conn);
?>