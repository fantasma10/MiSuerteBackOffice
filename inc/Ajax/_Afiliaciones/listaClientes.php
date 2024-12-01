<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");

	function acentos($txt){
		return (!preg_match("!!u", $txt))? utf8_encode($txt) : $txt;
	}

	$idCliente	= (!empty($_POST['idCliente']))? $_POST['idCliente'] : 0;
	$sortCol	= (!empty($_POST['sortCol']))? $_POST['sortCol'] : 0;
	$sortDir	= (!empty($_POST['sortDir']))? $_POST['sortDir'] : 'ASC';
	$strToFind	= (!empty($_POST['texto']))? ($_POST['texto']) : '';
	$start		= (!empty($_POST['start']))? $_POST['start'] : 0;
	$limit		= (!empty($_POST['limit']))? $_POST['limit'] : -1;
	$real		= (!empty($_POST['real']))? $_POST['real'] : 0;

	$QUERY = "CALL `afiliacion`.`SP_CLIENTE_LISTA`($idCliente, $sortCol, '$sortDir', '$strToFind', $start, $limit, $real);";

	$sql = $RBD->query($QUERY);

	$data = array();

	if(!$RBD->error()){
		while($row = mysqli_fetch_assoc($sql)){
			$data[] = array(
				'idCliente' 	=> $row['idCliente'],
				'idSubCadena' 	=> $row['idSubCadena'],
				'nombreCliente'	=> acentos($row['nombreCliente'])
			);
		}

		$response = array(
			'data'	=> $data,
			'total'	=> count($data)
		);
	}
	else{
		$LOG->error("Consulta lista de Clientes ".$QUERY." | ".$RBD->error());
		$response = array(
			'data'		=> array(),
			'success'	=> false,
			'errmsg'	=> $RBD->error()
		);
	}

	echo json_encode($response);
?>