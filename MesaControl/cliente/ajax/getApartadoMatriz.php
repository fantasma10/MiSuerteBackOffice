<?php
       
include ('../../../inc/config.inc.php');

$idCliente = $_POST["idCliente"];

$query = "CALL `redefectiva`.`sp_select_contactos_cadena`($idCliente);";
$sql = $RBD->query($query);
$datos = array();
$index = 0;

while ($row = mysqli_fetch_assoc($sql)) {
    $datos[$index]["nIdContacto"] = $row["nIdContacto"];
    $datos[$index]["nIdArea"] = $row["nIdArea"];
    $datos[$index]["sAreaNombre"] = utf8_encode($row["sAreaNombre"]);
    $datos[$index]["sNombre"] = utf8_encode($row["sNombre"]);
    $datos[$index]["sMail"] = utf8_encode($row["sMail"]);
    $datos[$index]["sTelefono"] = $row["sTelefono"];
    $datos[$index]["sComentario"] = utf8_encode($row["sComentario"]);
    $datos[$index]["nIdEstatus"] = $row["nIdEstatus"];
    $index++;
}

echo json_encode($datos);

?>
 