<?php
	include("../../config.inc.php");

	$cadena = isset($_POST['cadena'])? $_POST['cadena'] : NULL;

	if ( isset($cadena) ) {
		$cadena = utf8_decode($cadena);
		$SQL = "select idCadena, idSubCadena from `redefectiva`.`dat_cliente` where `idCliente` = $cadena;";
		$cliente = $RBD->query($SQL);
		$cliente = $cliente->fetch_assoc();

		$cadena = utf8_decode($cadena);
		$SQL = "CALL `redefectiva`.`SP_FILTER_SUBCADENAS`('{$cliente['idSubCadena']}', '{$cliente['idCadena']}');";
		$result = $RBD->SP($SQL);
		if ( $RBD->error() == '' ) {
			$cadenas = array();
			while ( $cadena = $result->fetch_assoc() ) {
				$cadenas[] = array(
					'valor' => $cadena['idSubCadena'],
					'texto' => utf8_encode($cadena['nombreSubCadena'])
				);
			}

			$json['datos'] = $cadenas;
			$json['predeterminado'] = $cliente['idSubCadena'];

			echo json_encode($json);
		}
	}
?>
