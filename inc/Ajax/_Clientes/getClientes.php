<?php
	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");

	$text = isset($_POST['text'])? $_POST['text'] : NULL;
	
	if(!empty($text)) {
		$str = utf8_decode($text);
		$SQL = "CALL `redefectiva`.`SP_FIND_CLIENTES`('$str');";
		$result = $RBD->SP($SQL);

		if ( $RBD->error() == '' ) {
			$clientes = array();
			while ( $cliente = $result->fetch_assoc() ) {
				array_push( $clientes,
					array(
						'label'			=> utf8_encode($cliente['nombreCliente']),
						'value'			=> utf8_encode($cliente['nombreCliente']),
						'idCliente'		=> $cliente['idCliente'],
						'nombre'		=> utf8_encode($cliente['nombreCliente']),
						'idCadena'		=> $cliente['idCadena'],
						'nombreCadena'	=> (!preg_match('!!u', $cliente['nombreCadena']))? htmlentities($cliente['nombreCadena']) : $cliente['nombreCadena'],
						'idSubCadena'		=> $cliente['idSubCadena'],
						'ctaContable'		=> $cliente['ctaContable'],
						'RFC'		=> $cliente['RFC'],
						'numCuenta'		=> $cliente['numCuenta'],
					) 
				);
			}
			echo json_encode($clientes);		
		}
		else{
			echo json_encode(array());
		}		
		
	}
?>