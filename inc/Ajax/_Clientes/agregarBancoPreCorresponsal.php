<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");
include("../../obj/XMLPreCorresponsal.php");

$corresponsalID = (isset($_POST['corresponsalID'])) ? $_POST['corresponsalID'] : '';
$bancoID = (isset($_POST['bancoID'])) ? $_POST['bancoID'] : '';

$query = "CALL `prealta`.`SP_INSERT_PRECORRESPONSALIA`($corresponsalID, $bancoID);";
$result = $RBD->SP($query);
if ( $RBD->error() == "" ) {
	$oCorresponsal = new XMLPreCorresponsal($RBD,$WBD);
	$oCorresponsal->load($corresponsalID);
	$oCorresponsal->agregarCorresponsalia($bancoID);
	$oCorresponsal->GuardarXML();
	$query = "CALL `prealta`.`SP_LOAD_PRECORRESPONSALIAS`($corresponsalID);";
	$result = $RBD->SP($query);
	if ( $RBD->error() == "" ) {
		if ( $result->num_rows > 0 ) {
			$data = "";
			$data .= "<select class=\"form-control m-bot15\" id=\"ddlBanco\">";
			$data .= "<option value=\"-1\">Elegir Banco</option>";
			while ( $row = mysqli_fetch_assoc($result) ) {
				$data .= "<option value=\"{$row['idBanco']}\">{$row['descBanco']}</option>";
			}
			$data .= "</select>";
			echo $data;
		} else {
			$data = "";
			$data .= "<select class=\"form-control m-bot15\" id=\"ddlBanco\">";
			$data .= "<option value=\"-1\">Elegir Banco</option>";
			$data .= "</select>";
			echo $data;			 
		}
	} else {
		echo $RBD->error();
	}
} else {
	echo $RBD->error();
}

?>
