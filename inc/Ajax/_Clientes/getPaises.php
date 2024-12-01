<?php
	include("../../config.inc.php");
	
	$pais = isset($_POST['pais'])? $_POST['pais'] : NULL;

	if ( isset($pais) ) {
		$pais = utf8_decode($pais);
		$SQL = "CALL `redefectiva`.`SP_FIND_PAISES`('$pais');";
		$result = $RBD->SP($SQL);

		if ( $RBD->error() == '' ) {
			$paises = array();
			while ( $pais = $result->fetch_assoc() ) {
				array_push( $paises, array( 'label' => utf8_encode($pais['nombre']), 'value' => utf8_encode($pais['nombre']),
				'idPais' => $pais['idPais'], 'nombre' => utf8_encode($pais['nombre']) ) );
			}
			echo json_encode( $paises );		
		}		
		
	}
?>
