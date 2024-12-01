<?php
	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	$text = isset($_POST['text'])? $_POST['text'] : NULL;

	if(!empty($text)) {
		$str = utf8_decode($text);
		$SQL = "CALL `redefectiva`.`SP_FIND_CLIENTES`('$str');";

		$newData = array();

		$array_params = array(
			array(
				'name'	=> 'str',
				'type'	=> 's',
				'value'	=> $str
			)
		);

		$oRdb->setSDatabase('redefectiva');
		$oRdb->setSStoredProcedure('SP_FIND_CLIENTES');
		$oRdb->setParams($array_params);

		$arrRes = $oRdb->execute();

		if($arrRes['bExito'] == false || $arrRes['nCodigo'] != 0){
			echo json_encode(array('suggestions' => array()));
			exit();
		}

		$data = $oRdb->fetchAll();

		foreach($data as $row){
			$newData[] = array(
				'data'			=> $row['idCliente'],
				'value'			=> $row['idCliente']." : ".utf8ize($row['nombreCliente']),
				'nIdCadena'		=> $row['idCadena'],
				'sNombreCadena'	=> utf8ize($row['nombreCadena'])
			);
		}

		$suggestions = array('suggestions' => $newData);

		echo json_encode($suggestions);
	}
	else{
		echo json_encode(array('suggestions' => array()));
	}
?>
