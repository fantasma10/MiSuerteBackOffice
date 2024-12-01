<?php
       
include ('../../../inc/config.inc.php');

$idCliente = $_POST["idCliente"];

$sQuery = "CALL redefectiva.sp_select_cliente_familias($idCliente);";
$resultcont = $WBD->query($sQuery);
$DATSFAM  = mysqli_fetch_array($resultcont);

$sQuerys = "CALL redefectiva.sp_select_cliente_secciones($idCliente);";
$resultcont = $WBD->query($sQuerys);
$DATSSECCION  = mysqli_fetch_array($resultcont);
        
$datosSeccion = array();
$datosSeccion[0] = $DATSSECCION["bSeccion1"];
$datosSeccion[1] = $DATSSECCION["bSeccion2"];
$datosSeccion[2] = $DATSSECCION["bSeccion3"];
$datosSeccion[3] = $DATSSECCION["bSeccion4"];
$datosSeccion[4] = $DATSSECCION["bSeccion5"];
$datosSeccion[5] = $DATSSECCION["bSeccion6"];
$datosSeccion[6] = $DATSSECCION["bSeccion7"];
$datosSeccion[7] = $DATSSECCION["bSeccion8"];

$sQuery = "CALL redefectiva.sp_select_cliente_apartadoTipo($idCliente);";
$resultcont = $WBD->query($sQuery);
$DATS  = mysqli_fetch_array($resultcont);
                    
$res = json_encode(array(
    "idCliente" => $idCliente,
    "idRegimen"  => $DATS['idRegimen'],
    "idCadena"  => $DATS['idCadena'],
    "nombreCadena"  => utf8_encode($DATS['nombreCadena']),
    "idEstatus" => $DATS['idEstatus'],
    "idTipoAcceso"  => $DATS['idTipoAcceso'],
    "RFC" => $DATS['RFC'],
    "nPersonaFisica" => $DATS['nPersonaFisica'],
    "nSolicitante" => $DATS['nSolicitante'],

    "nIntegrador"  => $DATS['nIntegrador'],
    "nTicketFiscal"  => $DATS['nTicketFiscal'],
    "nCuantasForelo"  => $DATS['nCuantasForelo'],
    "nFacturaTAE"  => $DATS['nFacturaTAE'],

    "nModoPruebas"  => $DATS['nModoPruebas'],
    "nModoProduccion"  => $DATS['nModoProduccion'],
    "dFecInicioPruebas"  => $DATS['dFecInicioPruebas'],
    "dFecInicioProduccion"  => $DATS['dFecInicioProduccion'],
    
    "nRetieneIVA"  => $DATS['nRetieneIVA'],
    "nRetieneISR"  => $DATS['nRetieneISR'],
    
    "Nombre"  => utf8_encode($DATS['Nombre']),
    "Materno"  => utf8_encode($DATS['Materno']),
    "Paterno"  => utf8_encode($DATS['Paterno']),

    "idFamilias"  => $DATSFAM['idFamilias'],
    "nombreFamilias"  => $DATSFAM['nombreFamilias'],

    "secciones" => $datosSeccion,
    "nIdSeccion" => $DATSSECCION['nIdSeccionCliente'],
    "bRevision" => $DATSSECCION['bRevision'],
    "dataSecciones" => $DATSSECCION,
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
 
