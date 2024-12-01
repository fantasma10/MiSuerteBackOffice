<?php
	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
	
	$idCliente = isset( $_POST['idCliente'] )? $_POST['idCliente'] : -500;
	$esSubcadena = isset( $_POST['esSubcadena'] )? $_POST['esSubcadena'] : -500;
	
	if ( $idCliente < 0 ) {
		echo json_encode( array( "codigo" => 1,
		"mensaje" => "No es posible guardar los datos porque falta proporcionar un ID de Cliente" ) );
		exit();
	}
	
	if ( $esSubcadena < 0 ) {
		echo json_encode( array( "codigo" => 2,
		"mensaje" => "No es posible cargar los datos porque falta proporcionar parametro esSubcadena" ) );
		exit();
	}
	
	$query = "CALL `redefectiva`.`SP_CLIENTE_GET`($idCliente, $esSubcadena);";
	//var_dump("query: $query");
	$sql = $RBD->query($query);

	if ( !$RBD->error() ) {
		if ( $sql->num_rows > 0 ) {
			$row = mysqli_fetch_assoc($sql);
			if ( $esSubcadena ) {
				//var_dump("TEST A");
				$nombreSubcadena = (!preg_match('!!u', $row['nombreSubCadena']))? utf8_encode($row['nombreSubCadena']) : $row['nombreSubCadena'];
				$idTipoForelo = $row['idTipoForelo'];
				echo json_encode( array( "codigo" => 0, "nombre" => $nombreSubcadena, "tipoForelo" => $idTipoForelo, "mensaje" => "Datos cargados exitosamente" ) );
			} else {
				//var_dump("idRegimen: {$row['idRegimen']}");
				if ( $row['idRegimen'] == 1 ) {
					$nombre = (!preg_match('!!u', $row['Nombre']))? utf8_encode($row['Nombre']) : $row['Nombre'];
					$paterno = (!preg_match('!!u', $row['Paterno']))? utf8_encode($row['Paterno']) : $row['Paterno'];
					$materno = (!preg_match('!!u', $row['Materno']))? utf8_encode($row['Materno']) : $row['Materno'];
					$nombreCompleto = $nombre." ".$paterno." ".$materno;
					$idTipoForelo = $row['idTipoForelo'];
					echo json_encode( array( "codigo" => 0, "nombre" => $nombreCompleto, "tipoForelo" => $idTipoForelo,"mensaje" => "Datos cargados exitosamente" ) );
				} else if ( $row['idRegimen'] == 2 ) {
					$razonSocial = $row['RazonSocial'];
					$idTipoForelo = $row['idTipoForelo'];
					echo json_encode( array( "codigo" => 0, "nombre" => $razonSocial, "tipoForelo" => $idTipoForelo, "mensaje" => "Datos cargados exitosamente" ) );
				} else if ( $row['idRegimen'] == 3 ) {
					if ( $row['razonSocial'] != '' ) {
						$razonSocial = $row['RazonSocial'];
						$idTipoForelo = $row['idTipoForelo'];
						echo json_encode( array( "codigo" => 0, "nombre" => $razonSocial, "tipoForelo" => $idTipoForelo, "mensaje" => "Datos cargados exitosamente" ) );						
					} else {
						$nombre = (!preg_match('!!u', $row['Nombre']))? utf8_encode($row['Nombre']) : $row['Nombre'];
						$paterno = (!preg_match('!!u', $row['Paterno']))? utf8_encode($row['Paterno']) : $row['Paterno'];
						$materno = (!preg_match('!!u', $row['Materno']))? utf8_encode($row['Materno']) : $row['Materno'];
						$nombreCompleto = $nombre." ".$paterno." ".$materno;
						$idTipoForelo = $row['idTipoForelo'];
						echo json_encode( array( "codigo" => 0, "nombre" => $nombreCompleto, "tipoForelo" => $idTipoForelo, "mensaje" => "Datos cargados exitosamente" ) );					
					}
				}
			}
		}
	} else {
		echo json_encode( array( "codigo" => 3, "mensaje" => "Error al consultar datos del Cliente: ".$RBD->error() ) );
	}
?>
