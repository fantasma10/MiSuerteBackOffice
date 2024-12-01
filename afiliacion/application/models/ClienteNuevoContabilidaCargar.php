
<?php
       
include ('../../../inc/config.inc.php');
$RFC = /*'OEAV800710BB3';//*/$_POST['rfc'];
$sQuery = "call afiliacion.SP_CLIENTES_NUEVOS_CONTABILIDAD('$RFC');";
$resultctes =  $WBD->query($sQuery);
$DATS  = mysqli_fetch_array($resultctes);
               
               
$idcte              =    $DATS['idCliente'];
$idsubcad           =    $DATS['idSubCadena'];
$rfc                =    $DATS['RFC'];
$razsoc             =    utf8_encode($DATS['RazonSocial']);
$fecreg             =    $DATS['FecRegistro'];
$nomregi            =    $DATS['nombreRegimen'];
$nomcadena          =    utf8_encode($DATS['nombreCadena']);
$correo             =    $DATS['Correo'];
$numcta             =    $DATS['numCuenta'];
$ctacontable        =    $DATS['ctaContable'];
$tipoforelo         =    $DATS['descTipoForelo'];
$tiporeembolso      =    $DATS['desreembolso'];
$tipoliquidacion    =    $DATS['descliquidacion'];
$referencia         =    $DATS['referencia'];
$clabe              =    $DATS['CLABE'];
$ctetel             =    $DATS['telcte'];

$calle              =    utf8_encode($DATS['calleDireccion']);
$numext             =    $DATS['numeroExtDireccion'];
$numint             =    $DATS['numeroIntDireccion'];
$nomcolonia         =    utf8_encode($DATS['nombreColonia']);
$nommunicipio       =    utf8_encode($DATS['D_mnpio']);
$nomestado          =    utf8_encode($DATS['d_estado']);
$nompais            =    utf8_encode($DATS['nompais']);
$cp                 =    $DATS['cpDireccion'];  

$datosJson = json_encode(array(
        "idcliente"         =>"$idcte",
        "idsubcadena"       =>"$idsubcad",
        "rfc"               =>"$rfc",
        "razonsocial"       =>"$razsoc",
        "recharegistro"     =>"$fecreg",
        "nombreregimen"     =>"$nomregi",
        "nombrecadena"      =>"$nomcadena",
        "correo"            =>"$correo",
        "numerocuenta"      =>"$numcta",
        "cuentacontable"    =>"$ctacontable",
        "tipoforelo"        =>"$tipoforelo",
        "tiporeembolso"     =>"$tiporeembolso",
        "tipoliquidacion"   =>"$tipoliquidacion",
        "referencia"        =>"$referencia",
        "clabe"             =>"$clabe",
        "telefonocliente"   =>"$ctetel",
    
        "calle"             =>"$calle",
       "numeroexterior"    =>"$numext",
         "numerointerior"    =>"$numint",
        "colonia"   => "$nomcolonia",
        "municipio"         =>"$nommunicipio",
        "estado"            =>"$nomestado",
        "paiss"              =>"$nompais",
        "cp"                =>"$cp"
));

echo $datosJson;




?>
 
