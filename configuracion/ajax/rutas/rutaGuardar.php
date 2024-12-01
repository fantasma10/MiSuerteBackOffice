<?php
        
include ('../../../inc/config.inc.php');


$prod       = $_POST['producto'];
$prov       = $_POST['proveedor'];
$con        = $_POST['conector'];
$stat       = $_POST['estatus'];
$desc       = utf8_encode($_POST['descripcion']);
$sku        = $_POST['sku'];
$ini        = $_POST['inivigencia'];
$fin        = $_POST['finvigencia'];
$min        = $_POST['minimo'];
$max        = $_POST['maximo'];
$porcostrut = $_POST['porcostoruta'];
$impcostrut = $_POST['impcostoruta'];
$porcomprod = $_POST['porcomprod'];
$impcomprod = $_POST['impcomprod'];
$porcomcte  = $_POST['porcomcte'];
$impcomcte  = $_POST['impcpmcte'];
$porcomusr  = $_POST['porcomusr'];
$impcomusr  = $_POST['impcomusr'];
$usr        = $_POST['usr'];




	$sQuery = "CALL redefectiva.SP_CREAR_RUTA('$prod', '$prov',  '$con','$desc','$sku', '$stat',   '$ini', '$fin', '$min', '$max',  '$porcostrut', '$impcostrut',  '$porcomprod', '$impcomprod',  '$porcomcte', '$impcomcte', '$porcomusr', '$impcomusr', '$usr');";



//echo $sQuery;
$result = $WBD->query( $sQuery );
$data  = mysqli_fetch_array($result);
  
$code =    $data['code'];
$msg =    $data['msg'];


echo json_encode(array("code"=>"$code","msg"=>"$msg"));

?>