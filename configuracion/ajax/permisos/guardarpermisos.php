<?php

include ('../../../inc/config.inc.php');


$idpermisoo     = $_POST['idpermisoo'];
$version        = $_POST['version'];
$ruta           = $_POST['ruta'];
$producto       = $_POST['producto'];

$cadenap         = $_POST['cadenap'];
$clientep        = $_POST['clientep'];
$sucursalp       = $_POST['sucursalp'];



$maximo         = $_POST['maximo'];
$minimo         = $_POST['minimo'];

$impcomercio    = $_POST['impcomercio'];
$impgrupo       = $_POST['impgrupo'];
$impusuario     = $_POST['impusuario'];
$impespecial    = $_POST['impespecial'];
$impcosto       = $_POST['impcosto'];


$porcomercio    = $_POST['porcomercio'];
$porgrupo       = $_POST['porgrupo'];
$porusuario     = $_POST['porusuario'];
$porespecial    = $_POST['porespecial'];
$porcosto       = $_POST['porcosto'];

$usuario        = $_POST['usr'];
$estatus        = $_POST['estatus'];



$query = "CALL redefectiva.SP_CREAR_PERMISOS_PRODUCTO( '$idpermisoo','$version', '$ruta' ,  '$producto','$cadenap','$clientep','$sucursalp', '$maximo', '$minimo',  '$porcomercio' ,'$porgrupo', '$porusuario',  '$porespecial', '$porcosto','$impcomercio','$impgrupo', '$impusuario', '$impespecial', '$impcosto', '$usuario','$estatus')";
//echo $query;
$resulpermiso = $WBD->query($query);
$DATS  = mysqli_fetch_array($resulpermiso);
$code = $DATS['code'];
$msg = $DATS['msg'];
$datos = array('code' => $code,'msg' => $msg,);
echo json_encode($datos);


?>