<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1);

	include("../../../inc/config.inc.php");
	include("../../../inc/session.ajax.inc.php");

	$CLABE = (!empty($_POST["CLABE"]))? $_POST["CLABE"] : 0;

	$sql = $WBD->query("CALL `redefectiva`.`SP_FIND_BANCO_CLABE`('$CLABE')");

	if(!$WBD->error()){
		$data = array("idBanco"=>0, "nombreBanco" => "");

		if(mysqli_num_rows($sql) == 1){
			$data = mysqli_fetch_assoc($sql);
		}

		echo json_encode(array(
			"showMessage"	=> 0,
			"msg"			=> "",
			"data"			=> $data
		));
	}
	else{
		echo json_encode(array(
			"showMessage"	=> 1,
			"msg"			=> "Ha ocurrido un Error, Inténtelo de Nuevo Más Tarde",
			"errmsg"		=> $WBD->error()
		));
	}
?>