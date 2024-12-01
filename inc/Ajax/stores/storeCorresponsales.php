<?php

	include("../../config.inc.php");
	include("../../session.inc.php");

	$idCadena		= (isset($_POST['idCadena']) AND $_POST['idCadena'] > -1 )? $_POST['idCadena'] : -1;
	$idSubCadena	= (isset($_POST['idSubCadena']) AND $_POST['idSubCadena'] > -1 )? $_POST['idSubCadena'] : -1;

	$data = array();

	if($idCadena >-1 AND $idSubCadena >-1){
		$sql = $RBD->query("CALL `redefectiva`.`SP_LOAD_CORRESPONSALES`($idCadena, $idSubCadena);");

		if(!$RBD->error()){
			while($row = mysqli_fetch_assoc($sql)){
				$data[] = array(
					'idCorresponsal'		=> $row['idCorresponsal'],
					'nombreCorresponsal'	=> (!preg_match("!!u", $row['nombreCorresponsal']))? utf8_encode($row['nombreCorresponsal']) : $row['nombreCorresponsal']
				);
			}
		}
	}
	echo json_encode(array(
		'data'	=> $data,
		'total'	=> count($data)
	));

?>