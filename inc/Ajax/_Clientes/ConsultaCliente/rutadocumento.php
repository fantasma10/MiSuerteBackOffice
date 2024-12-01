<?php

include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
//include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");

$tipo  = $_POST['tipo'];
$RFC = $_POST['rfc'];
$sql = "CALL redefectiva.sp_select_ruta_documento($tipo, '$RFC');";
$res = $WBD->query($sql);
 $DATS  = mysqli_fetch_array($res);

echo json_encode(array("ruta" => $DATS['ruta']));



?>
	