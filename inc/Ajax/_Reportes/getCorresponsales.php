<?php
	include("../../config.inc.php");

	$cadena = isset($_POST['cadena'])? $_POST['cadena'] : NULL;

	if ( isset($cadena) ) {
		$cadena = utf8_decode($cadena);
		$SQL = "select idSubCadena from `redefectiva`.`dat_cliente` where `idCliente` = $cadena;";
		$cliente = $RBD->query($SQL);
		$cliente = $cliente->fetch_assoc();

		$cadena = utf8_decode($cadena);
		$SQL = "CALL `redefectiva`.`SP_LOAD_CORRESPONSALES`('{$cliente['idSubCadena']}', '{$cliente['idSubCadena']}');";
		$result = $RBD->SP($SQL);

		if ( $RBD->error() == '' )
		{
			$cadenas = array();
			while ( $cadena = $result->fetch_assoc() )
			{
				$cadenas[] = array(
					'valor' => $cadena['idCorresponsal'],
					'texto' => utf8_encode($cadena['nombreCorresponsal'])
				);
			}

			$json['datos'] = $cadenas;
			$json['predeterminado'] = -1;

			echo json_encode($json);
		}
	}
?>
