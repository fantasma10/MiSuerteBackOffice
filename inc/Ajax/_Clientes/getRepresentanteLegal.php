<?php
	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");

	$text = isset($_POST['text'])? $_POST['text'] : NULL;
	
	if(!empty($text)) {
		$str = utf8_decode($text);
		$SQL = "CALL `redefectiva`.`SP_GET_REPLEGAL`('$str');";
		$result = $RBD->SP($SQL);
		if ( $RBD->error() == '' ) {
			$representantes = array();
			while ( $representante = mysqli_fetch_assoc($result) ) {
				array_push( $representantes,
					array(
						'label'					=> utf8_encode($representante['nombreCompleto']),
						'value'					=> utf8_encode($representante['nombreCompleto']),
						'idRepresentanteLegal'	=> $representante['idRepLegal'],
						'nombre'				=> utf8_encode($representante['nombre']),
						'apellidoPaterno'		=> utf8_encode($representante['apellidoPaterno']),
						'apellidoMaterno'		=> utf8_encode($representante['apellidoMaterno']),
						'nombreCompleto'		=> utf8_encode($representante['nombreCompleto']),
						'idCliente'				=> $representante['idCliente'],
						'nombreCliente'			=> utf8_encode($representante['nombreCliente']),
					) 
				);
			}
			echo json_encode($representantes);
		} else {
			echo json_encode(array());
		}
	}
?>