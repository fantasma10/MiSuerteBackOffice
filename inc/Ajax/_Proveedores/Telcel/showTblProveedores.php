<?php
	include("../../../config.inc.php");
	include("../../../session.inc.php");

	function _buscarEnArray($array, $key, $value){
		foreach($array as $arrays){
			if($arrays[$key]==$value){
				return $arrays;
			break;
			}
		}

		return false;
	}

	error_reporting(E_ALL);
	ini_set('display_errors',1);
	$QUERY	= "CALL `redefectiva`.`SP_PATCH_SELECT_TELCEROUTE`();";
	$SQL	= $RBD->SP($QUERY);

	$data	= array();

	if(!$RBD->error()){
		while($row = mysqli_fetch_assoc($SQL)){
			$data[] = $row;
		}

		foreach($data as $key => &$array){
			$nIdProvisional = $array['idProvisional'];
			$found = _buscarEnArray($data, 'idProveedor', $nIdProvisional);
			$array['nombreProveedorProvisional'] = '--';

			if(is_array($found)){
				$array['nombreProveedorProvisional'] = $found['nombreProveedor'];
			}
		}
	}
	else{
		echo json_encode(array(
			'bExito'	=> false,
			'nCodigo'	=> 99,
			'html'		=> '',
			'sMensaje'	=> 'Sin información para Mostrar'
		));
		exit();
	}

	echo json_encode(array(
		'bExito'	=> true,
		'nCodigo'	=> 0,
		'html'		=> '',
		'data'		=> $data
	));
?>