<?php
       
include ('../../../inc/config.inc.php');

$idCliente = $_POST["idCliente"];

$sQuery = "CALL redefectiva.sp_select_cliente_apartadoDatos($idCliente);";
$resultcont = $WBD->query($sQuery);
$DATS  = mysqli_fetch_array($resultcont);
//var_dump($DATS);
$res = json_encode(array(
    "idCliente" => $idCliente,
    "Nombre"  => utf8_encode($DATS['Nombre']),
    "Materno"  => utf8_encode($DATS['Materno']),
    "Paterno"  => utf8_encode($DATS['Paterno']),
    "RazonSocial"  => utf8_encode($DATS['RazonSocial']),
    "sNombreComercial" => utf8_encode($DATS['sNombreComercial']),
    "sRegimenSocietario" => utf8_encode($DATS['sRegimenSocietario']),

    "sActividadEconomica" => utf8_encode($DATS['sActividadEconomica']),

    "idDireccion"  => $DATS['idDireccion'],
    "calleDireccion"  => utf8_encode($DATS['calleDireccion']),
    "numeroIntDireccion"  => $DATS['numeroIntDireccion'],
    "numeroExtDireccion"  => $DATS['numeroExtDireccion'],
    "idPais"  => $DATS['idPais'],
    "idcEntidad"  => $DATS['idcEntidad'],
    "idcMunicipio"  => $DATS['idcMunicipio'],
    "idcLocalidad"  => $DATS['idcLocalidad'],
    "idcColonia"  => $DATS['idcColonia'],
    "cpDireccion"  => $DATS['cpDireccion'],
    "sNombreEstado"  => utf8_encode($DATS['sNombreEstado']),
    "sNombreMunicipio"  => utf8_encode($DATS['sNombreMunicipio']),
    "sNombreColonia"  => utf8_encode($DATS['sNombreColonia']),
    "nombreColonia"  => utf8_encode($DATS['nombreColonia']),
    "nombreEstado"  => utf8_encode($DATS['nombreEstado']),
    "nombreCiudad"  => utf8_encode($DATS['d_ciudad'])
));

echo $res;

?>
 
