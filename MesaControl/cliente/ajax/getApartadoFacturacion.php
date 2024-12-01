<?php
       
include ('../../../inc/config.inc.php');

$idCliente = $_POST["idCliente"];

$query = "CALL `redefectiva`.`sp_select_cliente_confFacturas`($idCliente);";
$sql = $RBD->query($query);
$datos = array();
$index = 0;

while ($row = mysqli_fetch_assoc($sql)) {
    $datos[$index]["nTipoFactura"] = $row["nTipoFactura"];
    $datos[$index]["sUsoCFDI"] = $row["sUsoCFDI"];
    $datos[$index]["sClaveProductoServicio"] = $row["sClaveProductoServicio"];
    $datos[$index]["sUnidad"] = $row["sUnidad"];
    $datos[$index]["sFormaPago"] = $row["sFormaPago"];
    $datos[$index]["sMetodoPago"] = $row["sMetodoPago"];
    $datos[$index]["sCorreoDestino"] = $row["sCorreoDestino"];
    $datos[$index]["nPeriodoFacturacion"] = $row["nPeriodoFacturacion"];
    $datos[$index]["nDiaFacturacionSemanal"] = $row["nDiaFacturacionSemanal"];
    $datos[$index]["nIVA"] = $row["nIVA"];
    $datos[$index]["idEstatus"] = $row["idEstatus"];

    $datos[$index]['sSeccion1']             = ($row['sSeccion1']!== null) ? $row['sSeccion1'] : '{}';
    $datos[$index]['sSeccion2']             = ($row['sSeccion2']!== null) ? $row['sSeccion2'] : '{}';
    $datos[$index]['sSeccion3']             = ($row['sSeccion3']!== null) ? $row['sSeccion3'] : '{}';
    $datos[$index]['sSeccion4']             = ($row['sSeccion4']!== null) ? $row['sSeccion4'] : '{}';
    $datos[$index]['sSeccion5']             = ($row['sSeccion5']!== null) ? $row['sSeccion5'] : '{}';
    $datos[$index]['sSeccion6']             = ($row['sSeccion6']!== null) ? $row['sSeccion6'] : '{}';
    $datos[$index]['sSeccion7']             = ($row['sSeccion7']!== null) ? $row['sSeccion7'] : '{}';
    $datos[$index]['sSeccion8']             = ($row['sSeccion8']!== null) ? $row['sSeccion8'] : '{}';
    $datos[$index]['nIdActualizacion']      = ($row['nIdActualizacion']!== null) ? $row['nIdActualizacion'] : 0;
    $datos[$index]['bRevisionSecciones']    = $row['bRevisionSecciones'];

    $index++;
}

echo json_encode($datos);

?>
 
