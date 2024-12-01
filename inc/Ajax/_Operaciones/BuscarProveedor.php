<?php
	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");

	$idProducto = !empty($_POST['idProducto'])? $_POST['idProducto']:0;
	$idCadena = !empty($_POST['idCadena'])? $_POST['idCadena']:0;
	$idSubCadena = !empty($_POST['idSubCadena'])? $_POST['idSubCadena']:0;
	$idCorresponsal = !empty($_POST['idCorresponsal'])? $_POST['idCorresponsal']:0;
	
	function getProveedorProducto($RBD, $idProducto, $idCadena, $idSubCadena, $idCorresponsal){
		$sql = "SELECT PERM.`idRuta`, RUTA.`idProveedor`
		FROM `redefectiva`.`ops_permiso` AS PERM
		INNER JOIN `redefectiva`.`ops_ruta` AS RUTA
		ON ( RUTA.`idRuta` = PERM.`idRuta` )
		WHERE PERM.`idProducto` = $idProducto
		AND (PERM.`idCorresponsal` = $idCorresponsal
		OR (PERM.`idCadena` = $idCadena AND PERM.`idSubCadena` = $idSubCadena AND PERM.`idCorresponsal` = -1) 
		OR (PERM.`idCadena` = $idCadena AND PERM.`idSubCadena` = -1 AND PERM.`idCorresponsal` = -1)
		OR (PERM.`idCadena` = -1 AND PERM.`idSubCadena` = -1 AND PERM.`idCorresponsal` = -1 ))
		AND PERM.`idEstatusPermiso` = 0 AND PERM.`idFevPermiso` <= NOW() AND PERM.`idFsvPermiso` >= NOW()
		ORDER BY PERM.`idPrioridadPermiso` DESC LIMIT 1;";
		$resultado = $RBD->query($sql);
		if($resultado){
			if(mysqli_num_rows($resultado) == 1){
				$row = mysqli_fetch_assoc($resultado);
				$idProveedor = $row["idProveedor"];
			}
		}
		return $idProveedor;
	}
	
	$idProveedor = getProveedorProducto($RBD, $idProducto, $idCadena, $idSubCadena, $idCorresponsal);
	
	if ( isset($idProveedor) ) {
		$resultado = array( "codigoRespuesta" => 0, "idProveedor" => $idProveedor, "mensaje" => "Consulta de Proveedor exitosa." );
	} else {
		$resultado = array( "codigoRespuesta" => 500, "idProveedor" => $idProveedor, "mensaje" => "No fue posible encontrar el Proveedor." );
	}
	
	echo json_encode($resultado);
?>