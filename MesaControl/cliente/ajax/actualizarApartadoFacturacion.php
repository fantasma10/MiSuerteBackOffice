<?php
       
$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT'];
include ('../../../inc/config.inc.php');

$idCliente = $_POST["idCliente"];

$nTipoFactura = $_POST["nTipoFactura"];
$sUsoCFDI = $_POST["sUsoCFDI"];
$sClaveProductoServicio = $_POST["sClaveProductoServicio"];
$sUnidad = $_POST["sUnidad"];
$sFormaPago = $_POST["sFormaPago"];
$sMetodoPago = $_POST["sMetodoPago"];
$sCorreoDestino = $_POST["sCorreoDestino"];
$nPeriodoFacturacion = $_POST["nPeriodoFacturacion"];
$nDiaFacturacionSemanal = $_POST["nDiaFacturacionSemanal"];
$nIVAComision = $_POST["nIVAComision"];

$sQuery = "CALL redefectiva.sp_update_cliente_confFacturas(
    $idCliente, 
    $nTipoFactura, 
    -1, 
    -1, 
    -1, 
    '$sUsoCFDI', 
    '$sClaveProductoServicio', 
    '$sUnidad', 
    '$sFormaPago', 
    '$sMetodoPago', 
    '', 
    $nPeriodoFacturacion, 
    $nDiaFacturacionSemanal, 
    -1, 
    $nIVAComision, 
    -1, 
    '', 
    '', 
    '', 
    '$sCorreoDestino'
);";
$resultcont = $WBD->query($sQuery);
$DATS = mysqli_fetch_array($resultcont);

// Si hay error al guardar salir
if ($DATS['code'] != 0) {
    echo json_encode(array("code" => $DATS['code'], "msg" => $DATS['msg']));
    exit;
}

// Si aplica factura tae - guardar dato
if ($_POST["nFacturaTAE"] == "1") {
    $nTipoFacturaTAE = $_POST["nTipoFacturaTAE"];
    $sUsoCFDITAE = $_POST["sUsoCFDITAE"];
    $sClaveProductoServicioTAE = $_POST["sClaveProductoServicioTAE"];
    $sUnidadTAE = $_POST["sUnidadTAE"];
    $sFormaPagoTAE = $_POST["sFormaPagoTAE"];
    $sMetodoPagoTAE = $_POST["sMetodoPagoTAE"];
    $sCorreoDestinoTAE = $_POST["sCorreoDestinoTAE"];
    $nPeriodoFacturacionTAE = $_POST["nPeriodoFacturacionTAE"];
    $nDiaFacturacionSemanalTAE = $_POST["nDiaFacturacionSemanalTAE"];
    
    $sQuery = "CALL redefectiva.sp_update_cliente_confFacturas(
        $idCliente, 
        $nTipoFacturaTAE, 
        -1, 
        -1, 
        -1, 
        '$sUsoCFDITAE', 
        '$sClaveProductoServicioTAE', 
        '$sUnidadTAE', 
        '$sFormaPagoTAE', 
        '$sMetodoPagoTAE', 
        '', 
        $nPeriodoFacturacionTAE, 
        $nDiaFacturacionSemanalTAE, 
        -1, 
        0, 
        -1, 
        '', 
        '', 
        '', 
        '$sCorreoDestinoTAE'
    );";
    $resultcont = $WBD->query($sQuery);

    // Si hay error al guardar salir
    $DATS = mysqli_fetch_array($resultcont);
    if ($DATS['code'] != 0) {
        echo json_encode(array("code" => $DATS['code'], "msg" => $DATS['msg']));
        exit;
    }
}

$nRetieneIVA = $_POST["nRetieneIVA"];
$nRetieneISR = $_POST["nRetieneISR"];

$sQuery = "CALL redefectiva.sp_update_cliente_retenciones($idCliente, $nRetieneIVA, $nRetieneISR);";
$resultcont = $WBD->query($sQuery);

include($PATH_PRINCIPAL."/MesaControl/cliente/ajax/actualizarSeccion.php");

$res = json_encode(array(
    "code"  => 0,
    "msg" => "Datos de facturación actualizados correctamente"
));

echo $res;
       
?>
        
       