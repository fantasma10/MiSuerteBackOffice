
<?php
        
include ('../../../inc/config.inc.php');
$idsuc = $_POST['idsucur'];
        $sQuery = "CALL `afiliacion`.`SP_SUCURSAL_BUSCAR_ID`('$idsuc')";
        $resultSocio = $WBD->query($sQuery);
        $suc  = mysqli_fetch_array($resultSocio);
        $succount = $suc['NUM_SUCURSALES'];
        $json = json_encode(array("cuenta"=>"$succount")); 
            echo $json;
       // mysqli_close($conn);

?>

