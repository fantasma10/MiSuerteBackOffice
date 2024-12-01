<?php

	/*error_reporting(E_ALL);
	ini_set('display_errors', 2);
*/
	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");

	$idCliente = (!empty($_POST['idCliente']))? $_POST['idCliente'] : 0;

	if($idCliente > 0){
		$QUERY = "CALL `afiliacion`.`SPA_ALTA_CLIENTE`($idCliente, @resCode, @resMsg)"; //Store Procedure para dar de alta un cliente
		$WBD->query($QUERY);
		//echo "error ".$WBD->error();
		if(!$WBD->error()){

			$sql = $WBD->query("SELECT @resCode AS codigo, @resMsg AS msg;");

			$res = mysqli_fetch_assoc($sql);
			$codigo		= $res['codigo'];
			$message	= $res['msg'];

			$LOG->error("Crear Sucursal idCliente => ".$idCliente." Codigo => ".$codigo." Mensaje => ".$message);

			$response = array(
				"showMsg"		=> 1,
				"success"		=> ($codigo == 0)? true : false,
				"msg"			=> $codigo." : ".$message,
				"codigo"		=> $codigo,
				"res"			=> $res
			);
		}
		else{
			$response = array(
				"showMsg"		=> 1,
				"success"		=> false,
				"msg"			=> 'Error',
				"res"			=> $WBD->error()
			);
		}
	}
	else{
		//$LOG->error("No se puede crear Cliente ".$idCliente);
		$response = array(
			'success'	=> false,
			'msg'		=> "Cliente Inválido",
			'errmsg'	=> "id cliente 0"
		);
	}

	echo json_encode($response);
?>