<?php 
include ('../../../inc/config.inc.php');

$idpermiso = $_POST['idpermiso'];


$squery = "CALL redefectiva.SP_SELECT_PERMISO_POR_ID('$idpermiso');";
$resultado = $WBD->query($squery);
$DATS  = mysqli_fetch_array($resultado);


$idpermiso      = $DATS['idPermiso'];
$idproducto     = $DATS['idProducto'];
$idversion      = $DATS['idVersionPermiso'];
$idruta         = $DATS['idRuta'];
$icadena        = $DATS['idCadena'];
$idsubcadena    = $DATS['idSubCadena'];
$idsucursal     = $DATS['idCorresponsal'];
$idestatus      = $DATS['idEstatusPermiso'];
$maximo         = $DATS['impMaxPermiso'];
$minimo         = $DATS['impMinPermiso'];

$porcomercio    = $DATS['perComCorresponsal'];
$porgrupo       = $DATS['perComGrupo'];
$porusuario     = $DATS['perComCliente'];
$porespecial    = $DATS['perComEspecial'];
$porcosto       = $DATS['perCostoPermiso'];

$impcomercio    = $DATS['impComCorresponsal'];
$impgrupo       = $DATS['impcomGrupo'];
$impusuario     = $DATS['impComCliente'];
$impespecial    = $DATS['impcomEspecial'];
$impcosto       = $DATS['impcostoPermiso'];


$datos = array(

"idpermiso"      => "$idpermiso",
"idproducto"     => "$idproducto",
"idversion"      => "$idversion",
"idruta"         => "$idruta",
"icadena"        => "$icadena",
"idsubcadena"    => "$idsubcadena",
"idsucursal"     => "$idsucursal",
"idestatus"      => "$idestatus",
"maximo"         => "$maximo",
"minimo"         => "$minimo",

"porcomercio"    => "$porcomercio",
"porgrupo"       => "$porgrupo",
"porusuario"     => "$porusuario",
"porespecial"    => "$porespecial",
"porcosto"       => "$porcosto",

"impcomercio"    => "$impcomercio",
"impgrupo"       => "$impgrupo",
"impusuario"     => "$impusuario",
"impespecial"    => "$impespecial",
"impcosto"       => "$impcosto",
"idestatus"      => "$idestatus",

);

echo json_encode($datos);
?>

