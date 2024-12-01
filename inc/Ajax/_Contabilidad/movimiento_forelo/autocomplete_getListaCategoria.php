<?php
	include("../../../config.inc.php");
	include("../../../customFunctions.php");

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$nIdCadena 			= (isset($_POST["nIdCadena"]) AND $_POST["nIdCadena"] != "")? $_POST["nIdCadena"] : -1;
	$nIdSubCadena		= (isset($_POST["nIdSubCadena"]) AND $_POST["nIdSubCadena"] != "")? $_POST["nIdSubCadena"] : -1;
	$nIdCorresponsal	= (isset($_POST["nIdCorresponsal"]) AND $_POST["nIdCorresponsal"] != "")? $_POST["nIdCorresponsal"] : -1;
	$str				= (!empty($_POST["text"]))? $_POST["text"] : "";
	$categoria			= (!empty($_POST["categoria"]))? $_POST["categoria"] : 0;
	$nIdEstatus			= (isset($_POST["nIdEstatus"]) && $_POST['nIdEstatus'] > -1)? $_POST["nIdEstatus"] : -1;

	if($categoria > 0){
		$str	= utf8_decode($str);

		if(is_numeric($str)){
			switch ($categoria) {
				case '1':
					$nIdCadena = $str;
				break;

				case '2':
					$nIdSubCadena = $str;
				break;

				case '3':
					$nIdCorresponsal = $str;
				break;
			}
		}

		$array_params = array(
			array(
				'name'	=> 'str',
				'type'	=> 's',
				'value'	=> $str
			),
			array(
				'name'	=> 'categoria',
				'type'	=> 'i',
				'value'	=> $categoria
			),
			array(
				'name'	=> 'nIdCadena',
				'type'	=> 'i',
				'value'	=> $nIdCadena
			),
			array(
				'name'	=> 'nIdSubCadena',
				'type'	=> 'i',
				'value'	=> $nIdSubCadena
			),
			array(
				'name'	=> 'nIdCorresponsal',
				'type'	=> 'i',
				'value'	=> $nIdCorresponsal
			),
			array(
				'name'	=> 'nIdEstatus',
				'type'	=> 'i',
				'value'	=> $nIdEstatus
			)
		);

		$oRdb->setBDebug(1);

		$oRdb->setSDatabase('redefectiva');
		$oRdb->setSStoredProcedure('SP_FIND_BY_CATEGORIA');
		$oRdb->setParams($array_params);

		$result = $oRdb->execute();

		$data = $oRdb->fetchAll();
		$data = utf8ize($data);

		$newData = array();

		foreach($data as $row){
			switch($categoria){
				case '1':
					$newData[] = array(
						'data'			=> $row['idCadena'],
						'value'			=> $row['idCadena'].": ".$row['nombreCadena'],
						'idCadena'		=> $row['idCadena'],
						'nombreCadena'	=> $row['nombreCadena']
					);
				break;

				case '2':
					$newData[] = array(
						'data'				=> $row['idSubCadena'],
						'value'				=> $row['idSubCadena'].": ".$row['nombreSubCadena'],
						'idCadena'			=> $row['idCadena'],
						'nombreCadena'		=> $row['nombreCadena'],
						'idSubCadena'		=> $row['idSubCadena'],
						'nombreSubCadena'	=> $row['nombreSubCadena']
					);
				break;

				case '3':
					$newData[] = array(
						'data'					=> $row['idCorresponsal'],
						'value'					=> $row['idCorresponsal'].": ".$row['nombreCorresponsal'],
						'idCadena'				=> $row['idCadena'],
						'nombreCadena'			=> $row['nombreCadena'],
						'idSubCadena'			=> $row['idSubCadena'],
						'nombreSubCadena'		=> $row['nombreSubCadena'],
						'idCorresponsal'		=> $row['idCorresponsal'],
						'nombreCorresponsal'	=> $row['nombreCorresponsal']
					);
				break;

				default:
					# code...
					break;
			}
		}

		$suggestions = array(
			'suggestions'	=> $newData
		);

		echo json_encode($suggestions);
	}
	else{
		echo json_encode(array('suggestions' => array()));
	}
?>
