
<?php
        
include ('../../../inc/config.inc.php');
$telsuc = $_POST['telsucur'];
$telsucu = preg_replace("/[^0-9]/","", $telsuc);
        $sQuery = "CALL `afiliacion`.`SP_SUCURSAL_BUSCAR_TELEFONO`('$telsucu');";
        $resultSocio = $WBD->query($sQuery);
        $suc  = mysqli_fetch_array($resultSocio);
        $succount = $suc['NUM_SUCURSALES'];
        $json = json_encode(array("cuenta"=>"$succount")); 
            echo $json;
//printf("Error: %s\n", mysqli_error($conn));
       // mysqli_close($conn);

?>

