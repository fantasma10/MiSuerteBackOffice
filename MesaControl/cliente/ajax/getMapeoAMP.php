<?php
       
include ('../../../inc/config.inc.php');
// $idCliente = $_POST["idCliente"];

// $DATMAPEO = null;
    $sQuery = "CALL aquimispagos.sp_select_mapeoCliente_RE('0');";
    $resultcont = $oRAMP->query($sQuery);
    $index = 0;
    $datos = null;

    while ($row = mysqli_fetch_assoc($resultcont)) {
        $datos[$index]["nIdSubCadenaRE"] = $row["nIdSubCadenaRE"];
        $index++;
    }

    $datos = json_encode($datos);

// echo "resultado: "; print_r($datos);
?>
 
