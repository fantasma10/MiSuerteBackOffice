<?php

include ('../../../inc/config.inc.php');

$idproducto = $_POST['idproducto'];


$squery = "CALL redefectiva.SP_SELECT_PRODUCTOS_PORID('$idproducto');";
$resultado = $WBD->query($squery);
$DATS  = mysqli_fetch_array($resultado);

$idprod = $DATS['idProducto'];
$nomprods = $DATS['idProducto'].' '.utf8_encode($DATS['descProducto']);


$datos = array(
"idprod"=>$idprod,
"nomprod"=>$nomprods   
);


echo json_encode($datos);



?>