<?php
       
include ('../../../inc/config.inc.php');

$idCliente = $_POST["idCliente"];

$query = "CALL `redefectiva`.`sp_select_cliente_documentos`($idCliente);";
$sql = $RBD->query($query);
$datos = array();
$index = 0;

while ($row = mysqli_fetch_assoc($sql)) {
    $datos[$index]["nIdDocumento"] = $row["nIdDocumento"];
    $datos[$index]["nIdTipoDocumento"] = $row["nIdTipoDocumento"];
    $datos[$index]["sNombreDocumento"] = $row["sNombreDocumento"];
    $datos[$index]["sRutaDocumento"] = $row["sRutaDocumento"];
    $index++;
}

echo json_encode($datos);

?>
 
