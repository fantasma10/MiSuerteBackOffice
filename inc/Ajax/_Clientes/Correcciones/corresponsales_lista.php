<?php

	include '../../../config.inc.php';

	$post				= (!empty($_POST['strBuscar']))? trim($_POST['strBuscar']) : '';
	$nIdCorresponsal	= -1;
	$strBuscar			= '';

	if(is_numeric($post)){
		$nIdCorresponsal	= (int)$post;
		$strBuscar			= '';
	}
	else{
		$strBuscar = trim($post);
	}
	$QUERY = 'call `redefectiva`.`SP_LOAD_CORRESPONSALES_BY_PARAMS`(-1,-1,'.$nIdCorresponsal.',-1,-1,-1,-1,0,1000,0,0,"'.$strBuscar.'")';

	$sql = $RBD->query($QUERY);
	$data = array();
	if(!$RBD->error()){
		if(mysqli_num_rows($sql) >= 1){
			while($row = mysqli_fetch_assoc($sql)){
				$data[] = array(
					"id"					=> $row['idCorresponsal'],
					"label"					=> utf8_encode($row['nombreCorresponsal']),
					"value" 				=> utf8_encode($row['nombreCorresponsal']),
					"idCorresponsal"		=> $row['idCorresponsal'],
					"nombreCorresponsal"	=> utf8_encode($row['nombreCorresponsal'])
				);
			}
		}
	}
	else{
		echo $RBD->error();
	}

	echo json_encode($data);

?>