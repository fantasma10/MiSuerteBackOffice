<?php
	include("../../config.inc.php");
	
	$subcadena = isset($_POST['subcadena'])? $_POST['subcadena'] : NULL;
	
	if ( isset($subcadena) ) {
		$subcadena = utf8_decode($subcadena);
		$SQL = "CALL `redefectiva`.`SP_FIND_SUBCADENAS`('$subcadena');";
		$result = $RBD->SP($SQL);

		if ( $RBD->error() == '' ) {
			$subcadenas = array();
			while ( $subcadena = $result->fetch_assoc() ) {
				array_push( $subcadenas,
					array(
						'label'			=> utf8_encode($subcadena['nombreSubCadena']),
						'value'			=> utf8_encode($subcadena['nombreSubCadena']),
						'idSubCadena'	=> $subcadena['idSubCadena'],
						'nombre'		=> utf8_encode($subcadena['nombreSubCadena']),
						'idCadena'		=> $subcadena['idCadena'],
						'nombreCadena'	=> (!preg_match('!!u', $subcadena['nombreCadena']))? htmlentities($subcadena['nombreCadena']) : $subcadena['nombreCadena']
					) 
				);
			}
			echo json_encode( $subcadenas );		
		} else {
		
		}		
		
	}
?>