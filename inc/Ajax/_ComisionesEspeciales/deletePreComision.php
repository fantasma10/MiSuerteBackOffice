<?php

	include("../../../inc/config.inc.php");
	include("../../../inc/session.ajax.inc.php");

	$idPermiso = (!empty($_POST['idPermiso']))? $_POST['idPermiso'] : -1;

	$sql = $WBD->query("CALL `prealta`.`SP_DELETE_PRE_COMISION`($idPermiso)");

	$res = mysqli_fetch_assoc($sql);

	if(!$WBD->error()){
		if($res['eliminados'] >= 1){
			$array = array('showMsg' => 0, 'msg' => 'Operación Exitosa', 'errmsg' => '');
		}
		else{
			$array = array('showMsg' => 1, 'msg' => 'Error General');
		}
	}
	else{
		$array = array('showMsg' => 1, 'msg' => 'Error General', 'errmsg' => $WBD->error());
	}

	echo json_encode($array);

?>