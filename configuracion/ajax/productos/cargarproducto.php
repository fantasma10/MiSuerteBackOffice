<?php
        
include ('../../../inc/config.inc.php');

$idproducto= $_POST['idprod'];

$sQuery = "CALL redefectiva.SP_SELECT_PRODUCTOS_PORID('$idproducto');";

//echo $sQuery;
$result = $WBD->query( $sQuery );
$data  = mysqli_fetch_array($result);

$idprod         =    $data['idProducto'];
$idfam          =    $data['idFamilia'];
$idsubfam       =    $data['idSubFamilia'];
$idemisor       =    $data['idEmisor'];

$nombemisor     =    $data['nombremisor'];

$desc           =    $data['descProducto'];
$abrev          =    $data['abrevProducto'];
$inivigencia    =    $data['idFevProducto'];
$finvigencia    =    $data['idFsvProducto'];
$idflujo        =    $data['idFlujoImporte'];
$max            =    $data['impMaxProducto'];
$min            =    $data['impMinProducto'];
$pcp            =    $data['perComProducto'];
$icp            =    $data['impComProducto'];
$pcc            =    $data['perComCorresponsal'];
$icc            =    $data['impComCorresponsal'];
$pcu            =    $data['perComCliente'];
$icu            =    $data['impComCliente'];
$arrserv        =    $data['tts'];
$skuProducto    =    $data['skuProducto'];
$idEstaProd     =    $data['idEstatusProducto'];


echo json_encode(array("idprod"      =>  "$idprod",
                       "idfam"      =>  "$idfam",
                       "idsubfam"   =>  "$idsubfam",
                       "idemisor"   =>  "$idemisor",
                       "nombemisor" =>  "$nombemisor",
                       "desc"       =>  "$desc",
                       "abrev"      =>  "$abrev",
                       "inivigencia"=>  "$inivigencia",
                       "finvigencia"=>  "$finvigencia",
                       "idflujo"    =>  "$idflujo",
                       "max"        =>  "$max",
                       "min"        =>  "$min",
                       "pcp"        =>  "$pcp",
                       "icp"        =>  "$icp",
                       "pcc"        =>  "$pcc",
                       "icc"        =>  "$icc",
                       "pcu"        =>  "$pcu",
                       "icu"        =>  "$icu",
                       "arrserv"    =>  "$arrserv",
                       "skuProducto"=>  "$skuProducto",
                       "idEstaProd" =>  "$idEstaProd"
                      
                      
                      ));

?>