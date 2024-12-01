<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	include '../../../config.inc.php';

	$QUERY	= 'call `redefectiva`.`SP_LOAD_VERSIONES`()';

	$sql	= $RBD->query($QUERY);
	$data	= array();

	if(!$RBD->error()){
		if(mysqli_num_rows($sql) >= 1){
			while($row = mysqli_fetch_assoc($sql)){
				if(!empty($row['idVersion']) && !empty($row['nombreVersion'])){
					$data[] = array(
						"nIdVersion"		=> $row['idVersion'],
						"sNombreVersion"	=> ($row['nombreVersion'])
					);
				}
			}
		}
	}
	else{
		echo $RBD->error();
	}

	echo json_encode(array(
		'nCodigo'	=> 0,
		'data'		=> $data
	));
?>