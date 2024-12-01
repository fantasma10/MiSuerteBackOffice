
<?php
        
include ('../../../inc/config.inc.php');

$idPermiso = $_POST['permiso'];


	$sQuery = "CALL afiliacion.SP_SELECT_PERMISO_POR_ID('$idPermiso')";
$resultVersion = $WBD->query( $sQuery );
$permiso  = mysqli_fetch_array($resultVersion); 

$idPermiso = $permiso['idPermiso'];
$version = $permiso['idVersionPermiso'];
$ruta = $permiso['idRuta'];
$producto = $permiso['idProducto'];
$porComCorr = $permiso['perComCorresponsal'];
$impComCorr = $permiso['impComCorresponsal'];
$porComGrp = $permiso['perComGrupo'];
$impComGrp = $permiso['impComGrupo'];
$porComCte = $permiso['perComCliente'];
$impComCte = $permiso['impComCliente'];
$porComEsp = $permiso['perComEspecial'];
$impComEsp = $permiso['impComEspecial'];
$porCostPerm = $permiso['perCostoPermiso'];
$impcostPerm = $permiso['impCostoPermiso'];
$impMaxPerm = $permiso['impMaxPermiso'];
$impMinPerm = $permiso['impMinPermiso'];


$permisoss = array(
    "perm" => $idPermiso,
    "version" => $version,
    "ruta" => $ruta,
    "producto" => $producto,
    "porComCorr" => $porComCorr,
    "impComCorr" => $impComCorr,
    "porComGrp" => $porComGrp,
    "impComGrp" => $impComGrp,
    "porComCte" => $porComCte,
    "impComCte" => $impComCte,
    "porComEsp" => $porComEsp,
    "impComEsp" => $impComEsp,
    "porCostPerm" => $porCostPerm,
    "impcostPerm" => $impcostPerm,
    "impMaxPerm" => $impMaxPerm,
    "impMinPerm" => $impMinPerm,


);


echo json_encode($permisoss);

?>
                    

