 

	
<?php
include ('../../../inc/config.inc.php');

$prosRFC = $_POST['rfcpros'];
	
			$sQueryPaq      = "CALL `afiliacion`.`SP_PROSPECTO_ELIMINAR_SOLICITUD`('$prosRFC');";
            
            $resultPaq = $WBD->query($sQueryPaq);

            $direccionss  = mysqli_fetch_array($resultPaq);


         $records = json_encode(array("records" => $direccionss['rows']));

//printf("Error: %s\n", mysqli_error($conn));
echo $records;


        //mysqli_close($conn);
?>