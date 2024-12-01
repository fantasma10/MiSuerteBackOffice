<?php
include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session2.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

$term = $_REQUEST[ "term" ];

$SQL = "CALL `redefectiva`.`SP_FIND_CLIENTES_ALL`('$term');";
$result = $RBD->SP($SQL);
if ( $RBD->error() == '' ) {
   $clientes = array();
   while ( $cliente = $result->fetch_assoc() ) {
      array_push( $clientes,
         array(
            'label'        => utf8_encode($cliente['nombreCliente']),
            'value'        => utf8_encode($cliente['nombreCliente']),
            'idCliente'    => $cliente['idCliente'],
            'nombre'    => utf8_encode($cliente['nombreCliente']),
            'idCadena'     => $cliente['idCadena'],
            'nombreCadena' => (!preg_match('!!u', $cliente['nombreCadena']))? htmlentities($cliente['nombreCadena']) : $cliente['nombreCadena'],
            'idSubCadena'     => $cliente['idSubCadena'],
            'ctaContable'     => $cliente['ctaContable'],
            'RFC'    => $cliente['RFC'],
            'numCuenta'    => $cliente['numCuenta'],
            'idCorresponsal'=> $cliente['idCorresponsal'],
         ) 
      );
   }
   echo json_encode($clientes);
}
else{
   echo json_encode(array());
}
?>