<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");

	$RFC = (!empty($_POST['RFC']))? $_POST['RFC'] : '';

	$tipoIdentificacion = 0;
	$numIdentificacion = '';


	$QUERY = "CALL `afiliacion`.`SP_REPRESENTANTELEGAL_GET`('$RFC')";
	$sql = $RBD->query($QUERY);

	if(!$RBD->error()){
		$numrows = mysqli_num_rows($sql);

		if($numrows > 0){
			$res = mysqli_fetch_assoc($sql);

			$response = array(
				'showMsg'	=> 0,
				'success'	=> true,
				'data'		=> array(
					'idRepLegal'		=> $res['idRepLegal'],
					'nombreRepLegal'	=> $res['nombreRepreLegal'],
					'apPRepreLegal'		=> $res['apPRepreLegal'],
					'apMRepreLegal'		=> $res['apMRepreLegal'],
					'idTipoIdent'		=> $res['idcTipoIdent'],
					'numIdentificacion'	=> $res['numIdentificacion'],
					'figPolitica'		=> $res['figPolitica'],
					'famPolitica'		=> $res['famPolitica'],
				)
			);
		}
		else{
			$response = array(
				'showMsg'	=> 0,
				'success'	=> false,
				'data'		=> array()
			);
		}
	}
	else{
		$response = array(
			'showMsg'	=> 0,
			'success'	=> false,
			'msg'		=> 'Error',
			'errmsg'	=> $RBD->error()
		);
	}

	echo json_encode($response);

?>