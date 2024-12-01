<?php

	include("../../../config.inc.php");
	include("../../../customFunctions.php");
	include("../../../session.ajax.inc.php");

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$nIdMovimiento	= !empty($_POST['nIdMovimiento'])? $_POST['nIdMovimiento'] : 0;
	$nIdUsuario		= $_SESSION['idU'];

	$oCargoAdm = new CargoAdministrativo();
	$oCargoAdm->setORdb($oRdb);
	$oCargoAdm->setOWdb($oWdb);
	$oCargoAdm->setNIdMovimiento($nIdMovimiento);
	$oCargoAdm->setNIdUsuario($nIdUsuario);

	$resultado = $oCargoAdm->devolverCargo();


	echo json_encode($resultado);

?>