<?php

	/*error_reporting(E_ALL);
	ini_set('display_errors', 1);*/

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");

	$data = array();

	$idCliente = (!empty($_POST['idCliente']))? $_POST['idCliente'] : 0;

	$oAf = new AfiliacionCliente($RBD, $WBD, $LOG);
	$oAf->load($idCliente);

	$idCadena = $oAf->IDCADENA;
	$idExpediente = $oAf->IDNIVEL;
	$QUERY = "CALL `afiliacion`.`SP_COSTOS_LOAD`(0, $idCadena, $idExpediente)";
	$sql = $RBD->query($QUERY);

	if(!$RBD->error()){

		$c  = 0;
		while($row = mysqli_fetch_assoc($sql)){
			$tipoF = $row['tipoForelo'];

			$data[$tipoF]['descTipoForelo'] = $row['descTipoForelo'];
			$data[$tipoF]['idTipoForelo'] = $row['tipoForelo'];

			$urlDestino = ($tipoF == 1)? "ConfiguracionCuenta.php" : "formnew5.php";

			if($row['minimoPuntos'] == 0 && $row['maximoPuntos'] == 0){
				$urlDestino = "#";
			}

			$data[$tipoF]['data'][$c] = array(
				'idCosto'			=> $row['idCosto'],
				'min'				=> $row['minimoPuntos'],
				'max'				=> $row['maximoPuntos'],
				'otro'				=> $row['otro'],
				'costo'				=> "\$".number_format($row['costo'], 2),
				'cuota'				=> "\$".number_format($row['cuotaAnual'], 2),
				'url'				=> $urlDestino
			);
			$c++;

		}
	}
	else{
		echo $RBD->error();
	}

	echo json_encode($data);
?>