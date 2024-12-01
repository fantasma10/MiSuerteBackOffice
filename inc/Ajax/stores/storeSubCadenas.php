<?php

	include("../../config.inc.php");
	include("../../session.inc.php");

	$idCadena = (isset($_POST['idCadena']) AND $_POST['idCadena'] > -1 )? $_POST['idCadena'] : -1;

	$sql = $RBD->query("CALL `redefectiva`.`SP_LOAD_SUBCADENAS`($idCadena);");
	$data = array();

	if($idCadena > -1){
		$data[] = array("idSubCadena" => 0, "nombreSubCadena" => "Unipuntos");
		if(!$RBD->error()){
			while($row = mysqli_fetch_assoc($sql)){
				$data[] = array(
					'idSubCadena'		=> $row['idSubCadena'],
					'nombreSubCadena'	=> (!preg_match("!!u", $row['nombreSubCadena']))? utf8_encode($row['nombreSubCadena']) : $row['nombreSubCadena']
				);
			}
		}
	}
	echo json_encode(array(
		'data'	=> $data,
		'total'	=> count($data)
	));

?>