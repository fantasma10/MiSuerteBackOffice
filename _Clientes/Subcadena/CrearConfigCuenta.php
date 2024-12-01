<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1);

	include("../../../inc/config.inc.php");
	include("../../../inc/session.ajax.inc.php");

	$tipoMovimiento = (!empty($_POST["tipoMovimiento"]))? $_POST["tipoMovimiento"] : 0;
	$destino		= (!empty($_POST["destino"]))? $_POST["destino"] : 0;
	$instruccion	= (!empty($_POST["instruccion"]))? $_POST["instruccion"] : 0;
	$clabe			= (!empty($_POST["clabe"]))? $_POST["clabe"] : "";
	$numCuenta		= (!empty($_POST["numCuenta"]))? $_POST["numCuenta"] : 0;
	$beneficiario	= (!empty($_POST["beneficiario"]))? trim($_POST["beneficiario"]) : 0;
	$rfc			= (!empty($_POST["rfc"]))? trim($_POST["rfc"]) : 0;
	$correo			= (!empty($_POST["correo"]))? trim($_POST["correo"]) : '';
	$idUsuario		= $_SESSION["idU"];

	$rfc = strtoupper($rfc);
	if($destino == 1){
		//echo "<pre>"; echo var_dump("CALL `data_contable`.`SP_ALTA_CUENTA_CONF`($idUsuario, $instruccion, $tipoMovimiento, $destino, '$numCuenta', @x, @y)"); echo "</pre>";
		$sql = $WBD->query("CALL `data_contable`.`SP_ALTA_CUENTA_CONF`($idUsuario, $instruccion, $tipoMovimiento, $destino, '$numCuenta', @x, @y)");
		//var_dump("Test 1: CALL `data_contable`.`SP_ALTA_CUENTA_CONF`($idUsuario, $instruccion, $tipoMovimiento, $destino, '$numCuenta', @x, @y)");
	}

	if($destino == 2){
		//echo "<pre>"; echo var_dump("CALL `data_contable`.`SP_ALTA_CUENTA_BANCO`($idUsuario, $instruccion, $tipoMovimiento, '$numCuenta', '$clabe', '$rfc', '$beneficiario', '$correo', @x, @y);"); echo "</pre>";
		$sql = $WBD->query("CALL `data_contable`.`SP_ALTA_CUENTA_BANCO`($idUsuario, $instruccion, $tipoMovimiento, '$numCuenta', '$clabe', '$rfc', '$beneficiario', '$correo', @x, @y);");
		//var_dump("Test 2: CALL `data_contable`.`SP_ALTA_CUENTA_BANCO`($idUsuario, $instruccion, $tipoMovimiento, '$numCuenta', '$clabe', '$rfc', '$beneficiario', '$correo', @x, @y);");
	}

	if(!$WBD->error()){
		$sql = $WBD->query("SELECT @x AS codigo, @y AS msg;");
		$res = mysqli_fetch_assoc($sql);

		$codigo		= $res['codigo'];
		$message	= $res['msg'];

		echo json_encode(array(
			"showMessage"	=> ($codigo > 0)? 1 : 0,
			"msg"			=> $message,
			"res"			=> $res
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