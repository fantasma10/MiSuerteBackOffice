<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");
include("../../obj/XMLPreCorresponsal.php");

$corresponsalID = (isset($_POST['corresponsalID'])) ? $_POST['corresponsalID'] : '';

$oCorresponsal = new XMLPreCorresponsal($RBD,$WBD);
$oCorresponsal->load($corresponsalID);
$corresponsalias = $oCorresponsal->getCorresponsalias();
$data = "";
foreach( $corresponsalias as $banco ){
	$nombreBanco = $oCorresponsal->getNombreCorresponsaliaBancaria($banco);
	$data .= "<tr>";
	$data .= "<td>$nombreBanco</td>";
	$data .= "</tr>";
}
echo $data;

?>
