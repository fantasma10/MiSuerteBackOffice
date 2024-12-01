<?php

include ('../../../inc/config.inc.php');

$idemisor = $_POST['emisor'];


$squery = "CALL redefectiva.SP_SELECT_EMISOR_POR_ID('$idemisor');";
$resultado = $WBD->query($squery);
$DATS  = mysqli_fetch_array($resultado);

$idemisors = $DATS['idEmisor'];
$descripemisor = $DATS['descEmisor'];
$abrevemisor = $DATS['abrevNomEmivosr'];
$estatusemisor = $DATS['idEstatusEmisor'];




$datos = array("idemisor" => "$idemisors",
              "descripcion" => "$descripemisor",
              "abrev" => "$abrevemisor",
              "estatus" => "$estatusemisor");


echo json_encode($datos);
?>