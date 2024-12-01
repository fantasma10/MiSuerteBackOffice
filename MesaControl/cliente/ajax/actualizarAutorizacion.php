<?php

include ('../../../inc/config.inc.php');

$usuario_logueado = $_SESSION['idU'];
$nIdCliente = $_POST['nIdCliente'];
$sRFC = $_POST['sRFC'];

$query = "CALL `redefectiva`.`sp_update_cliente_autorizacion`($nIdCliente, '', '$sRFC', $usuario_logueado);";
$resultado = $WBD->query($query);

$DATS = mysqli_fetch_array($resultado);
$res = json_encode(array(
    "code"  => $DATS['code'],
    "msg"  => $DATS['msg'],
    "forelo"  => $DATS['forelo'],
    "idsubcadena"  => $DATS['idsubcadena'],
    "paso"  => $DATS['paso'],
    "query" => $query
));

$q = "CALL `redefectiva`.`sp_update_cliente_estado_secciones`($nIdCliente, 2)";
$r = $WBD->query($q);

print json_encode($res);

?>