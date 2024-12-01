<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	include '../../../config.inc.php';

	$nIdCorresponsal = (!empty($_POST['nIdCorresponsal']))? trim($_POST['nIdCorresponsal']) : '';

	$QUERY = 'call `redefectiva`.`SP_PATCH_CLIENTE_BUSCAR`('.$nIdCorresponsal.')';

	$sql = $RBD->query($QUERY);
	$data = array();
	if(!$RBD->error()){
		if(mysqli_num_rows($sql) >= 1){
			while($row = mysqli_fetch_assoc($sql)){
				if(!empty($row['idCliente']) && !empty($row['sNombreCliente'])){
					$data[] = array(
						"nIdCliente"			=> $row['idCliente'],
						"sNombreCliente"		=> ($row['sNombreCliente'])
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