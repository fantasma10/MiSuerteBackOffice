<?php
	include("../../config.inc.php");
	
	$cadena = isset($_POST['cadena'])? $_POST['cadena'] : NULL;

	if ( isset($cadena) ) {
		$cadena = utf8_decode($cadena);
		$SQL = "CALL `redefectiva`.`SP_FIND_CADENAS`('$cadena');";
		$result = $RBD->SP($SQL);

		if ( $RBD->error() == '' ) {
			$cadenas = array();
			while ( $cadena = $result->fetch_assoc() ) {
				array_push( $cadenas, array( 'label' => utf8_encode($cadena['nombreCadena']), 'value' => utf8_encode($cadena['nombreCadena']),
				'idCadena' => $cadena['idCadena'], 'nombre' => utf8_encode($cadena['nombreCadena']) ) );
			}
			echo json_encode( $cadenas );		
		}
	}
?>
