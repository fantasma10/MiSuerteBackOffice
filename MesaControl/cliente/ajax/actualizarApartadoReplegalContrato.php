<?php
       
$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT'];
include ('../../../inc/config.inc.php');

$idCliente = $_POST["idCliente"];
$sNombreReplegal = mb_convert_encoding($_POST["sNombreReplegal"], 'ISO-8859-1', 'UTF-8');
$sPaternoReplegal = mb_convert_encoding($_POST["sPaternoReplegal"], 'ISO-8859-1', 'UTF-8');
$sMaternoReplegal = mb_convert_encoding($_POST["sMaternoReplegal"], 'ISO-8859-1', 'UTF-8');
$nTipoIdentificacion = $_POST["nTipoIdentificacion"];
$numIdentificacion = $_POST["numIdentificacion"];

$nVigencia = $_POST["txtNumVigencia"];
$fecContrato;
$fecRenovarContrato;
$fecRevisionCondicion;

if ($_POST["fecRevisionCondicion"]) {
    $fecRevisionCondicion = "'".$_POST["fecRevisionCondicion"]."'";
} else {
    $fecRevisionCondicion = "NULL";
}

if ($_POST["fecRenovarContrato"]) {
    $fecRenovarContrato = "'".$_POST["fecRenovarContrato"]."'";
} else {
    $fecRenovarContrato = "NULL";
}

if ($_POST["fecContrato"]) {
    $fecContrato = "'".$_POST["fecContrato"]."'";
} else {
    $fecContrato = "NULL";
}

// Actualizar datos
$sQuery = "CALL redefectiva.sp_update_cliente_apartadoReplContrato($idCliente, $nTipoIdentificacion, '$sNombreReplegal', '$sPaternoReplegal', '$sMaternoReplegal', '$numIdentificacion', $fecContrato, $nVigencia, $fecRenovarContrato, $fecRevisionCondicion);";
$resultcont = $WBD->query($sQuery);
$DATS  = mysqli_fetch_array($resultcont);  

// Si no hay error al guardar agregar los demas datos
if ($DATS['code'] == 0) {
    include($PATH_PRINCIPAL."/MesaControl/cliente/ajax/actualizarSeccion.php");  
}
   
$res = json_encode(array(
    "code"  => $DATS['code'],
    "msg" => $DATS['msg'],
    "query" => $sQuery
));

echo $res;

?>

