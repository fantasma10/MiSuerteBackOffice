<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");
include("../../obj/XMLPreCorresponsal.php");

$corresponsalID = (isset($_POST['corresponsalID'])) ? $_POST['corresponsalID'] : '';

$query = "CALL `prealta`.`SP_LOAD_BANCOSPRECORRESPONSAL`($corresponsalID);";
$result = $RBD->SP($query);
if ( $RBD->error() == "" ) {
	if ( $result->num_rows > 0 ) {
		$data = "";
		$data .= "<table class=\"tablabanco\">";
		$data .= "<tr>";
		$data .= "<th>Bancos Activos</th>";
		$data .= "<th>Eliminar</th>";
		$data .= "</tr>";
		while ( $row = mysqli_fetch_assoc($result) ) {
			$data .= "<tr>";
			$data .= "<td>{$row['descBanco']}</td>";
			$data .= "<td class=\"accion\">";
			$data .= "<a href=\"#\" onClick=\"eliminarCorresponsalia( $corresponsalID, {$row['idBanco']} )\"><i class=\"fa fa-times\"></i></a>";
			$data .= "</td>";
			$data .= "</tr>";
		}
		$data .= "</table>";
		echo $data;
	} else {
		$data = "";
		$data .= "<table class=\"tablabanco\">";
		$data .= "<tr>";
		$data .= "<th>Bancos Activos</th>";
		$data .= "<th>Eliminar</th>";
		$data .= "</table>";
		echo $data;	
	}
}

?>
