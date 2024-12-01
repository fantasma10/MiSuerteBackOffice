<?php
	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
	
	$idAfiliacion = !empty( $_POST['idAfiliacion'] )? $_POST['idAfiliacion'] : -500;
	$idCorresponsal = !empty( $_POST['idCorresponsal'] )? $_POST['idCorresponsal'] : -500;
	
	if ( $idAfiliacion <= 0 ) {
		echo json_encode( array( "codigo" => 1,
		"mensaje" => "No es posible guardar los datos porque falta proporcionar un ID de Afiliacion" ) );
		exit();
	}
	
	if ( $idCorresponsal <= 0 ) {
		echo json_encode( array( "codigo" => 2,
		"mensaje" => "No es posible guardar los datos porque falta proporcionar un ID de Corresponsal" ) );
		exit();
	}
	
	
	
?>