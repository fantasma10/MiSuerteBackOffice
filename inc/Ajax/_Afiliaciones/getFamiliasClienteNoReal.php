<?php
	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
	
	$idCliente = isset( $_POST['idCliente'] )? $_POST['idCliente'] : -500;
	
	if ( $idCliente <= 0 ) {
		echo json_encode( array( "codigo" => 1,
		"mensaje" => "No es posible guardar los datos porque falta proporcionar un ID de Cliente" ) );
		exit();
	}
	
	$query = "CALL `afiliacion`.`SP_FAMILIASCLIENTE_GET`($idCliente);";
	//var_dump($query);
	$sql = $RBD->query($query);
	
	if ( !$RBD->error() ) {
		if ( $sql->num_rows > 0 ) {
			$familias = array( "id" => array(), "nombre" => array() );
			while ( $row = mysqli_fetch_assoc($sql) ) {
				$familias["id"][] = $row["idFamilia"];
				$familias["nombre"][] = codificarUTF8($row["descFamilia"]);
			}
			echo json_encode( array( "codigo" => 0, "familias" => $familias, "mensaje" => "Familias cargadas exitosamente" ) );
		}
	} else {
		echo json_encode( array( "codigo" => 3, "mensaje" => "Error al consultar familias del Cliente: ".$RBD->error() ) );
	}
?>
