<?php

	include '../../../config.inc.php';

	$strBuscar = (!empty($_POST['strBuscar']))? trim($_POST['strBuscar']) : '';

	$QUERY = 'call `redefectiva`.`SP_FIND_SUBCADENAS`("'.$strBuscar.'")';

	$sql = $RBD->query($QUERY);
	$data = array();
	if(!$RBD->error()){
		if(mysqli_num_rows($sql) >= 1){
			while($row = mysqli_fetch_assoc($sql)){
				$data[] = array(
					"id"				=> $row['idSubCadena'],
					"label"				=> utf8_encode($row['nombreSubCadena']),
					"value" 			=> utf8_encode($row['nombreSubCadena']),
					"nIdSubCadena"		=> $row['idSubCadena'],
					"sNombreSubCadena"	=> utf8_encode($row['nombreSubCadena'])
				);
			}
		}
	}
	else{
		echo $RBD->error();
	}

	echo json_encode($data);

?>