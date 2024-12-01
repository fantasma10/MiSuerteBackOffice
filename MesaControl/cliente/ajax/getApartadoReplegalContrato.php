<?php
       
include ('../../../inc/config.inc.php');

$idCliente = $_POST["idCliente"];

$sQuery = "CALL redefectiva.sp_select_cliente_apartadoRepLegal($idCliente);";
$resultcont = $WBD->query($sQuery);
$DATS  = mysqli_fetch_array($resultcont);
                    
$res = json_encode(array(
    "idCliente" => $idCliente,
    "idRepLegal"  => $DATS['idRepLegal'],
    "nombreRepreLegal"  => utf8_encode($DATS['nombreRepreLegal']),
    "apPRepreLegal"  => utf8_encode($DATS['apPRepreLegal']),
    "apMRepreLegal"  => utf8_encode($DATS['apMRepreLegal']),
    "numIdentificacion" => $DATS['numIdentificacion'],
    "idcTipoIdent" => $DATS['idcTipoIdent'],
    "idEstatus" => $DATS['idEstatus'],
    "dFechaContrato"  => $DATS['dFechaContrato'],
    "nVigencia"  => $DATS['nVigencia'],
    "dFecRenovacion"  => $DATS['dFecRenovacion'],
    "dFecRevisionCondicionesComerciales"  => $DATS['dFecRevisionCondicionesComerciales'],
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
 
