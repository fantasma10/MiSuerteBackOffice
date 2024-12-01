<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");

	function acentos($txt){
		return (!preg_match("!!u", $txt))? utf8_encode($txt) : $txt;
	}

	$idAfiliacion	= (!empty($_POST['idAfiliacion']))? $_POST['idAfiliacion'] : 0;
	$sortCol		= (!empty($_POST['sortCol']))? $_POST['sortCol'] : 0;
	$sortDir		= (!empty($_POST['sortDir']))? $_POST['sortDir'] : 'ASC';
	$strToFind		= (!empty($_POST['texto']))? $_POST['texto'] : '';
	$start			= (!empty($_POST['start']))? $_POST['start'] : 0;
	$limit			= (!empty($_POST['limit']))? $_POST['limit'] : -1;

	$QUERY = "CALL `afiliacion`.`SP_SUCURSAL_LISTA`($idAfiliacion, $sortCol, '$sortDir', '$strToFind', $start, $limit, -1);";

	$sql = $RBD->query($QUERY);

	$data = array();

	if(!$RBD->error()){
		while($row = mysqli_fetch_assoc($sql)){
			$data[] = array(
				'idSucursal' 			=> $row['idCorresponsal'],
				'nombreCorresponsal'	=> acentos($row['NombreSucursal'])
			);
		}

		$response = array(
			'data'	=> $data,
			'total'	=> count($data)
		);
	}
	else{
		$LOG->error("Consulta lista de Sucursales ".$QUERY." | ".$RBD->error());
		$response = array(
			'data'		=> array(),
			'success'	=> false,
			'errmsg'	=> $RBD->error()
		);
	}

	echo json_encode($response);
?>