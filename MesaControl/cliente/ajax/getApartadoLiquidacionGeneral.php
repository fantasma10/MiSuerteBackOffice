<?php
       
include ('../../../inc/config.inc.php');

$idCliente = $_POST["idCliente"];

$sQuery = "CALL redefectiva.sp_select_cliente_apartadoLiquidacionOp($idCliente);";
$resultcont = $WBD->query($sQuery);
$DATS  = mysqli_fetch_array($resultcont);

$sQueryCalendario = "CALL redefectiva.sp_select_cliente_calendario($idCliente);";
$sql = $WBD->query($sQueryCalendario);

$datosCalendario = array();
$index = 0;
while ($row = mysqli_fetch_assoc($sql)) {
    $datosCalendario[$index]["nIdCalendario"] = $row["nIdCalendario"];
    $datosCalendario[$index]["nDiaCorte"] = $row["nDiaCorte"];
    $datosCalendario[$index]["sDiasPago"] = $row["sDiasPago"];
    $datosCalendario[$index]["nTipoRegistro"] = $row["nTipoRegistro"];
    $index++;
}

$res = json_encode(array(
    "nTipoLiquidacionRecaudo"  => $DATS['nTipoLiquidacionRecaudo'],
    "nLimiteCredito"  => $DATS['nLimiteCredito'],
    "nTipoLiquidacion"  => $DATS['nTipoLiquidacion'],
    "nRetieneTransferencia"  => $DATS['nRetieneTransferencia'],
    "nMontoTransferencia" => $DATS['nMontoTransferencia'],
    "nTndias" => $DATS['nTndias'],
    "nDiaPago" => $DATS['nDiaPago'],
    "nDiasAtras" => $DATS['nDiasAtras'],
    "nRetieneIVA" => $DATS['nRetieneIVA'],
    "nRetieneISR" => $DATS['nRetieneISR'],
    "idEstatus" => $DATS['idEstatus'],

    "nDescuentoForeloCliente"  => $DATS['nDescuentoForeloCliente'],
    "nDescuentoForeloPG"  => $DATS['nDescuentoForeloPG'],
    "nCadenaTicketFiscal"  => $DATS['nCadenaTicketFiscal'],
    "nValidaMonto" => $DATS['nValidaMonto'],
    "nComisionAdicional" => $DATS['nComisionAdicional'],
    "nPagoTipoLiquidacion" => $DATS['nPagoTipoLiquidacion'],
    "nPagoTnDias" => $DATS['nPagoTnDias'],
    "nPagoDiaPago" => $DATS['nPagoDiaPago'],
    "nPagoDiasAtras" => $DATS['nPagoDiasAtras'],
    "nTipoPrepagoComisiones" => $DATS['nTipoPrepagoComisiones'],
    "nRetieneComision" => $DATS['nRetieneComision'],

    "nCobroComisiones" => $DATS['nCobroComisiones'],
    "nIdCuentaRE" => $DATS['nIdCuentaRE'],
    "nCobroTipoLiquidacion" => $DATS['nCobroTipoLiquidacion'],
    "nCobroTnDias" => $DATS['nCobroTnDias'],
    "nCobroDiaPago" => $DATS['nCobroDiaPago'],
    "nCobroDiasAtras" => $DATS['nCobroDiasAtras'],

    "nIdBanco" => $DATS['nIdBanco'],
    "sNumCuenta" => $DATS['sNumCuenta'],
    "sCLABE" => $DATS['sCLABE'],
    "sBeneficiario" => utf8_encode($DATS['sBeneficiario']),
    "sCorreoEnvio" => $DATS['sCorreoEnvio'],
    "nIdPaisPago" => $DATS['nIdPaisPago'],
    "sSwift" => $DATS['sSwift'],
    "sABA" => $DATS['sABA'],
    "nIdMonedaExtranjero" => $DATS['nIdMonedaExtranjero'],

    "calendario" => $datosCalendario,

    "sSeccion1"                 => ($DATS['sSeccion1'] !== null) ? $DATS['sSeccion1'] : '{}',
    "sSeccion2"                 => ($DATS['sSeccion2'] !== null) ? $DATS['sSeccion2'] : '{}',
    "sSeccion3"                 => ($DATS['sSeccion3'] !== null) ? $DATS['sSeccion3'] : '{}',
    "sSeccion4"                 => ($DATS['sSeccion4'] !== null) ? $DATS['sSeccion4'] : '{}',
    "sSeccion5"                 => ($DATS['sSeccion5'] !== null) ? $DATS['sSeccion5'] : '{}',
    "sSeccion6"                 => ($DATS['sSeccion6'] !== null) ? $DATS['sSeccion6'] : '{}',
    "sSeccion7"                 => ($DATS['sSeccion7'] !== null) ? $DATS['sSeccion7'] : '{}',
    "sSeccion8"                 => ($DATS['sSeccion8'] !== null) ? $DATS['sSeccion8'] : '{}',
    "nIdActualizacion"          => ($DATS['nIdActualizacion'] !== null) ? $DATS['nIdActualizacion'] : 0,
    "bRevisionSecciones"        => $DATS['bRevisionSecciones'],

));   

echo $res;

?>
 
