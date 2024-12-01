<?php

include("../../inc/config.inc.php");
include("../../inc/session.ajax.inc.php");


$tipo  = (!empty($_POST["tipo"]))? $_POST["tipo"] : 0;

switch ($tipo) {
    
    case 1:

        $fechaInicio  = (!empty($_POST["fecha1"]))? $_POST["fecha1"] : 0;
        $fechaFin     = (!empty($_POST["fecha2"]))? $_POST["fecha2"] : 0;

        $sql = $MRDB->query("CALL `pronosticos`.`sp_select_pagos_premios`('$fechaInicio','$fechaFin')");
    
        $datos = array();
        $index = 0;

            while($row = mysqli_fetch_assoc($sql)){

                $datos[$index]["agencia"] = $row["sAgencia"];
                $datos[$index]["concursante"] = utf8_encode($row["sUsuario"]);
                $datos[$index]["premio"] = $row["nSaldoBruto"];
                $datos[$index]["dispersion"] = $row["dFechaUltPremio"];
                $datos[$index]["premioPagado"] = $row["nSaldoNeto"];
                $datos[$index]["fechaPago"] = $row["dFechaPagoPremio"];
                $datos[$index]["venta"] = $row["nMontoVenta"];
                $datos[$index]["fechaVenta"] = $row["dFechaVenta"];
                $datos[$index]["saldo"] = $row["nSaldoFinal"];
                $index++;

            }

        print json_encode($datos);

    break;




     case 2:

        $fechaInicio  = (!empty($_POST["fecha1"]))? $_POST["fecha1"] : 0;
        $fechaFin     = (!empty($_POST["fecha2"]))? $_POST["fecha2"] : 0;

        $sql = $MRDB->query("CALL `pronosticos`.`sp_select_pagos_cuenta`('$fechaInicio','$fechaFin')");
    
        $datos = array();
        $index = 0;

            while($row = mysqli_fetch_assoc($sql)){

                $datos[$index]["agencia"] = "Red Efectiva";
                $datos[$index]["concursante"] = "Red Efectiva";
                $datos[$index]["montoMonedero"] = $row["nMontoCargo"];
                $datos[$index]["fechaCargo"] = $row["dFechaContable"];
                $datos[$index]["venta"] = $row["nMontoCargo"];
                $datos[$index]["fechaVenta"] = $row["dFechaContable"];
                $datos[$index]["saldo"] = 0;
                $index++;

            }

        print json_encode($datos);

    break;


    
  


}
?>
