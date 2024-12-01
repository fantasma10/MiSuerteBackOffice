<?php
	include("../../config.inc.php");
	include("../../session.ajax.inc.php");
	
	$CLABE = isset( $_POST['CLABE'] ) ? $_POST['CLABE'] : NULL;
	
	if ( isset($CLABE) ) {
		$sql = "CALL `redefectiva`.`SP_FIND_BANCO_CLABE`('$CLABE')";
		$result = $RBD->SP($sql);
		if ( $RBD->error() == '' ) {
			if ( $result->num_rows == 1 ) {
				$row = $result->fetch_array();
				$bancoID = $row[0];
				$bancoNombre = (!preg_match("!!u", $row[1]))? utf8_encode($row[1]) : $row[1];
				echo json_encode( array( "codigoDeRespuesta" => 0, "mensajeDeRespuesta" => "Consulta exitosa",
				"bancoID" => $bancoID, "nombreBanco" => $bancoNombre) );
			}
		} else {
			echo json_encode( array( "codigoDeRespuesta" => 2, "mensajeDeRespuesta" => "No se pudo consultar la base de datos: ".$RBD->error() ) );
		}
	}
?>