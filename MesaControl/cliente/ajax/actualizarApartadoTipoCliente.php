<?php
       
include ('../../../inc/config.inc.php');

$idCliente = $_POST["idCliente"];
$idRegimen = $_POST["idRegimen"];
$idCadena = $_POST["idCadena"];
$idTipoAcceso = $_POST["idTipoAcceso"];
$nPersonaFisica = $_POST["nPersonaFisica"];

$selectFamilias = explode(',', $_POST['selectFamilias']);
$actualFamilias = explode(',', $_POST['actualFamilias']);

$nIntegrador = $_POST["nIntegrador"];
$nTicketFiscal = $_POST["nTicketFiscal"];
$nCuantasForelo = $_POST["nCuantasForelo"];
$nFacturaTAE = $_POST["nFacturaTAE"];

$nModoPruebas = $_POST["nModoPruebas"];
$nModoProduccion = $_POST["nModoProduccion"];

$idSubCadena = '-1';
$nSolicitante = $_POST["nSolicitante"];

$dFecInicioPruebas;
$dFecInicioProduccion;

if ($_POST["dFecInicioPruebas"]) {
    $dFecInicioPruebas = "'".$_POST["dFecInicioPruebas"]."'";
} else {
    $dFecInicioPruebas = "NULL";
}

if ($_POST["dFecInicioProduccion"]) {
    $dFecInicioProduccion = "'".$_POST["dFecInicioProduccion"]."'";
} else {
    $dFecInicioProduccion = "NULL";
}

// Actualizar datos
$sQuery = "CALL redefectiva.sp_update_cliente_apartadoTipo(
    $idCliente, 
    $idCadena, 
    $idTipoAcceso, 
    $idRegimen, 
    $nPersonaFisica, 
    $nIntegrador, 
    $nTicketFiscal, 
    $nFacturaTAE, 
    $nCuantasForelo, 
    $nModoPruebas, 
    $nModoProduccion, 
    $dFecInicioPruebas, 
    $dFecInicioProduccion, 
    $idSubCadena,
    $nSolicitante
);";

var_dump($sQuery);
die;

$resultcont = $WBD->query($sQuery);
$DATS = mysqli_fetch_array($resultcont);
         
// Si hay error al guardar no agregar los demas datos
if ($DATS['code'] != 0) {
    echo json_encode(array("code" => $DATS['code'], "msg" => $DATS['msg']));
    exit;
} else {

    // Cambiar estatus a todas las familias
    foreach ($actualFamilias as $familiaA) {
        $sQueryEstatus = "CALL redefectiva.SP_CLIENTEFAMILIAS_UPDATE($idCliente, $familiaA, 1)";
        $resulEstatus = $WBD->query($sQueryEstatus);
        $DATSEstatus  = mysqli_fetch_array($resulEstatus);
    }	

    // Agregar familias
    foreach ($selectFamilias as $familia){
        $sQueryFamilias = "CALL redefectiva.SP_CLIENTEFAMILIA_CREAR($idCliente, $familia)";
        $resulfamilias = $WBD->query($sQueryFamilias);
        $DATSfam  = mysqli_fetch_array($resulfamilias);
    }

    if ($_POST["noCadenaAnterior"]) {
        // Crear subcadena
    }

    // Si es primera vez y el cliente no esta activo, crear proceso secciones
    if ($_POST["primeraVez"] && $_POST["estatusCliente"] != 0) {
        $sQuery = "CALL redefectiva.sp_update_cliente_secciones($idCliente, 1, 1, 0, 0, 0, 0, 1, 1);";
        $resultcont = $WBD->query($sQuery);
    }

    $res = json_encode(array(
        "code"  => $DATS['code'],
        "msg" => $DATS['msg']
    ));
    
    echo $res;
}

?>
 
