<?php
#################################
#Session
#
if ($_SERVER["SERVER_PORT"] != 443){
    header("Location: https://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
    exit();
}

if(session_id() == '') {
    session_start();
}

if (isset($_SESSION['MiSuerte']))
{
	if($IP == $_SESSION['sip']){
		extract($_SESSION);
	}else{
		echo json_encode(array(
			'bExito'	=> false,
			'nCodigo'	=> 999,
			'sMensaje'	=> 'La sesion ha expirado'
		));
		exit;
	}
}else{
	echo json_encode(array(
		'bExito'	=> false,
		'nCodigo'	=> 999,
		'sMensaje'	=> 'La sesion ha expirado'
	));
	exit;
}

?>