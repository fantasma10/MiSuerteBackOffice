<?php
       
$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT'];
include ('../../../inc/config.inc.php');

$idCliente = $_POST["idCliente"];

/* LIQUIDACION GENERAL ------------------------------------------------------------*/
$nTipoLiquidacionRecaudo = $_POST["nTipoLiquidacionRecaudo"];
$nLimiteCredito = $_POST["nLimiteCredito"];
$nRetieneTransferencia = $_POST["nRetieneTransferencia"];
$nMontoTransferencia = $_POST["nMontoTransferencia"];
$nTipoLiquidacion = $_POST["nTipoLiquidacion"];
$nTndias = $_POST["nTndias"];
$nDiaPago = $_POST["nDiaPago"];
$nDiasAtras = $_POST["nDiasAtras"];

$sQuerys = "CALL redefectiva.sp_update_cliente_apartadoLiquidacion(
    $idCliente, 
    $nTipoLiquidacionRecaudo, 
    $nLimiteCredito, 
    $nRetieneTransferencia, 
    $nMontoTransferencia, 
    $nTipoLiquidacion, 
    $nTndias, 
    $nDiaPago, 
    $nDiasAtras
);";
$resultcont = $WBD->query($sQuerys);

// Si hay error al guardar generales salir
$DATS  = mysqli_fetch_array($resultcont);
if ($DATS['code'] != 0) {
    echo json_encode(array("code"  => $DATS['code'], "msg" => $DATS['msg']));
    exit;
}

// Actualizar calendarios
foreach($_POST['calendarioRecaudo'] as $index=>$item) {
    $sQueryCAL = "CALL redefectiva.sp_update_cliente_calendario($idCliente, 3, $index, '$item');";
    $resCAL = $WBD->query($sQueryCAL);
} 

/* PAGO DE COMISIONES ------------------------------------------------------------- */
$nDescForeloCli = $_POST["nDescForeloCli"];
$nDescForeloPG = $_POST["nDescForeloPG"];
$nCadenaTicket = $_POST["nCadenaTicket"];
$nValidaMonto = $_POST["nValidaMonto"];
$nComisionAdicional = $_POST["nComisionAdicional"];
$nTipoLiquidacionPago = $_POST["nTipoLiquidacionPago"];
$nTipoPrepago = $_POST["nTipoPrepago"];
$nRetieneComision = $_POST["nRetieneComision"];
$nPagoTnDias = $_POST["nPagoTnDias"] === '' ? 'NULL' : $_POST["nPagoTnDias"];
$nPagoDiaPago = $_POST["nPagoDiaPago"] === '' ? 'NULL' : $_POST["nPagoDiaPago"];
$nPagoDiasAtras = $_POST["nPagoDiasAtras"] === '' ? 'NULL' : $_POST["nPagoDiasAtras"];
$sCorreoEnvio = $_POST["sCorreoEnvio"];

$aux = $sQuery = "CALL redefectiva.sp_update_cliente_apartadoPagoComisiones(
    $idCliente, 
    $nDescForeloCli, 
    $nDescForeloPG, 
    $nCadenaTicket, 
    $nValidaMonto, 
    $nComisionAdicional, 
    $nTipoLiquidacionPago, 
    $nTipoPrepago, 
    $nPagoTnDias, 
    $nPagoDiaPago, 
    $nPagoDiasAtras, 
    '$sCorreoEnvio', 
    $nRetieneComision
);";

$resultcont = $WBD->query($sQuery);

// Si hay error al guardar pago salir
$DATS  = mysqli_fetch_array($resultcont);
if ($DATS['code'] != 0) {
    echo json_encode(array("code" => $DATS['code'], "msg" => $DATS['msg']));
    exit;
}

// Actualizar calendarios
foreach($_POST['calendarioPago'] as $index=>$item) {
    $sQueryCAL = "CALL redefectiva.sp_update_cliente_calendario($idCliente, 1, $index, '$item');";
    $resCAL = $WBD->query($sQueryCAL);
} 

// Actualizar banco
$nIdBanco = $_POST["nIdBanco"];
$sNumCuenta = $_POST["sNumCuenta"];
$sCLABE = $_POST["sCLABE"];
$sBeneficiario = mb_convert_encoding($_POST["sBeneficiario"], 'ISO-8859-1', 'UTF-8');
$nIdPaisPago = $_POST["nIdPaisPago"];
$sSwift = $_POST["sSwift"];
$sABA = $_POST["sABA"];
$nIdMonedaExt = $_POST["nIdMonedaExt"];

$sQuery = "CALL redefectiva.sp_update_cliente_apartadoBancos(
    $idCliente, 
    $nIdBanco, 
    '$sNumCuenta', 
    '$sCLABE', 
    '$sBeneficiario', 
    $nIdPaisPago, 
    '$sSwift', 
    '$sABA', 
    $nIdMonedaExt
);";
$resultcont = $WBD->query($sQuery);

// Si hay error al guardar banco salir
$DATS = mysqli_fetch_array($resultcont);
if ($DATS['code'] != 0) {
    echo json_encode(array("code" => $DATS['code'], "msg" => $DATS['msg']));
    exit;
}


// /* COBRO DE COMISIONES ------------------------------------------------------------- */
$nCobroComisiones = $_POST["nCobroComisiones"];
$nTipoLiquidacionCobro = $_POST["nTipoLiquidacionCobro"];
$nIdCuentaRE = $_POST["nIdCuentaRE"];
$nCobroTnDias = $_POST["nCobroTnDias"] === '' ? 'NULL' : $_POST["nCobroTnDias"];
$nCobroDiaPago = $_POST["nCobroDiaPago"] === '' ? 'NULL' : $_POST["nCobroDiaPago"];
$nCobroDiasAtras = $_POST["nCobroDiasAtras"] === '' ? 'NULL' : $_POST["nCobroDiasAtras"];

$sQuery = "CALL redefectiva.sp_update_cliente_apartadoCobroComisiones(
    $idCliente, 
    $nCobroComisiones, 
    $nTipoLiquidacionCobro, 
    $nIdCuentaRE, 
    $nCobroTnDias, 
    $nCobroDiaPago, 
    $nCobroDiasAtras
);";
$resultcont = $WBD->query($sQuery);

// Si hay error al guardar cobro salir
$DATS = mysqli_fetch_array($resultcont);
if ($DATS['code'] != 0) {
    echo json_encode(array("code" => $DATS['code'], "msg" => $DATS['msg']));
    exit;
}

// Actualizar calendarios
foreach($_POST['calendarioCobro'] as $index=>$item) {
    $sQueryCAL = "CALL redefectiva.sp_update_cliente_calendario($idCliente, 2, $index, '$item');";
    $resCAL = $WBD->query($sQueryCAL);
} 

include($PATH_PRINCIPAL."/MesaControl/cliente/ajax/actualizarSeccion.php");

$res = json_encode(array(
    "code"  => 0,
    "msg" => "Datos de liquidación actualizados correctamente",
    "query" => $aux
));

echo $res;

?>
 
