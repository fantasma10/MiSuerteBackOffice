<?php
ini_set("soap.wsdl_cache_enabled", "0");
include($_SERVER['DOCUMENT_ROOT'] . "/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT'] . "/inc/session2.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT'] . "/inc/customFunctions.php");

/*
case 1  selecciona la lista de proveedores
case 2  cambia el estatus del proveedor
case 3  selecciona la lista de rutas por proveedor	
*/

$tipo  = (!empty($_POST["tipo"])) ? $_POST["tipo"] : 0;
$perfil = (!empty($_POST["perfil"])) ? $_POST["perfil"] : 1; //1 administrador

switch ($tipo) {
	case 1:

		$p_estatus = ($perfil == 9) ? 0 : -1;
		$array_params = array(array('name' => 'p_estatus', 'value' => $p_estatus, 'type' => 'i'));
		// var_dump($array_params);
		$oRdb->setSDatabase('redefectiva');
		$oRdb->setSStoredProcedure('sp_select_proveedor_por_estatus');
		$oRdb->setParams($array_params);
		$result = $oRdb->execute();

		if ($result['nCodigo'] == 0) {
			$data = $oRdb->fetchAll();
			$datos = array();
			$index = 0;
			for ($i = 0; $i < count($data); $i++) {
				$datos[$index]["idProveedor"] = $data[$i]["idProveedor"];
				$datos[$index]["RFC"] = $data[$i]["RFC"];
				$datos[$index]["razonSocial"] = utf8_encode($data[$i]["razonSocial"]);
				$datos[$index]["idEstatusProveedor"] = $data[$i]["idEstatusProveedor"];
				if ($data[$i]["nIdTipoCliente"] == 1)
					$datos[$index]["tipo"] = "Integrador";
				else
					$datos[$index]["tipo"] = "Proveedor";
				$index++;
			}
			$oRdb->closeStmt();
			$totalDatos = $oRdb->foundRows();
			$oRdb->closeStmt();
		} else {
			$datos = 0;
			$totalDatos = 0;
		}
		$resultado = array(
			"iTotalRecords"     => $totalDatos,
			"iTotalDisplayRecords"  => $totalDatos,
			"aaData"        => $datos,
			"tipo" 			=> $tipo,
			"perfil" 		=> $perfil
		);
		echo json_encode($resultado);
		break;

	case 2:
		$idProveedor = $_POST["idProveedor"];
		$estatus = $_POST["estatus"];

		$array_params = array(
			array('name' => 'p_idProveedor', 'value' => $idProveedor, 'type' => 'i'),
			array('name' => 'p_estatus', 'value' => $estatus, 'type' => 'i'),
		);
		$oWdb->setSDatabase('redefectiva');
		$oWdb->setSStoredProcedure('sp_cambia_estatus_proveedor');
		$oWdb->setParams($array_params);
		$result = $oWdb->execute();
		if ($result['nCodigo'] == 0) {
			echo json_encode(array(
				"showMessage"	=> 0,
				"msg"			=> "Registro Actualizado."
			));
		} else {
			echo json_encode(array(
				"showMessage"	=> 1,
				"msg"			=> $result['sMensajeDetallado']
			));
		}
		$oWdb->closeStmt();
		break;

	case 3:
		$idProveedor = $_POST["idProveedor"];

		$array_params = array(
			array('name' => 'p_nIdProveedor', 'value' => $idProveedor, 'type' => 'i')
		);
		$oRdb->setSDatabase('redefectiva');
		$oRdb->setSStoredProcedure('sp_select_proveedor_producto');
		$oRdb->setParams($array_params);
		$result = $oRdb->execute();
		if ($result['nCodigo'] == 0) {
			$data = $oRdb->fetchAll();
			$datos = array();
			$index = 0;
			for ($i = 0; $i < count($data); $i++) {
				$datos[$index]["abrevProducto"] = utf8_encode($data[$i]["abrevProducto"]);
				$datos[$index]["idRuta"] = utf8_encode($data[$i]["idRuta"]);
				$datos[$index]["descRuta"] = utf8_encode($data[$i]["descRuta"]);
				$datos[$index]["idProducto"] = utf8_encode($data[$i]["idProducto"]);
				$datos[$index]["idConector"] = utf8_encode($data[$i]["idConector"]);
				$datos[$index]["skuProveedor"] = utf8_encode($data[$i]["skuProveedor"]);
				$datos[$index]["impMaxRuta"] = utf8_encode($data[$i]["impMaxRuta"]);
				$datos[$index]["impMinRuta"] = utf8_encode($data[$i]["impMinRuta"]);
				$datos[$index]["idFevRuta"] = utf8_encode($data[$i]["idFevRuta"]);
				$datos[$index]["idFsvRuta"] = utf8_encode($data[$i]["idFsvRuta"]);
				$datos[$index]["perCostoRuta"] = utf8_encode($data[$i]["perCostoRuta"] * 100);
				$datos[$index]["impCostoRuta"] = utf8_encode($data[$i]["impCostoRuta"]);
				$datos[$index]["perComisionProducto"] = utf8_encode($data[$i]["perComisionProducto"] * 100);
				$datos[$index]["impComisionProducto"] = utf8_encode($data[$i]["impComisionProducto"]);
				$datos[$index]["perComCliente"] = utf8_encode($data[$i]["perComCliente"] * 100);
				$datos[$index]["impComCliente"] = utf8_encode($data[$i]["impComCliente"]);
				$datos[$index]["perComCorresponsal"] = utf8_encode($data[$i]["perComCorresponsal"] * 100);
				$datos[$index]["impComCorresponsal"] = utf8_encode($data[$i]["impComCorresponsal"]);
				$datos[$index]["enableReverso"] = utf8_encode($data[$i]["enableReverso"]);
				$datos[$index]["idEstatusRuta"] = utf8_encode($data[$i]["idEstatusRuta"]);
				$datos[$index]["nPerPagoProveedor"] = utf8_encode($data[$i]["nPerPagoProveedor"] * 100);
				$datos[$index]["nImpPagoProveedor"] = utf8_encode($data[$i]["nImpPagoProveedor"]);
				$datos[$index]["nPerMargen"] = utf8_encode($data[$i]["nPerMargen"] * 100);
				$datos[$index]["nImpMargen"] = utf8_encode($data[$i]["nImpMargen"]);
				$index++;
			}
			$oRdb->closeStmt();
			$totalDatos = $oRdb->foundRows();
			$oRdb->closeStmt();
		} else {
			$datos = 0;
			$totalDatos = 0;
		}

		$resultado = array(
			"iTotalRecords"     => count($data),
			"iTotalDisplayRecords"  => count($data),
			"aaData"        => $datos
		);
		echo json_encode($resultado);
		break;

	default:
		# code...
		break;

	case 4:

		$p_estatus = $_POST["estatus"];
		$array_params = array(array('name' => 'p_estatus', 'value' => $p_estatus, 'type' => 'i'));
		// var_dump($array_params);
		$oRdb->setSDatabase('redefectiva');
		$oRdb->setSStoredProcedure('sp_select_proveedor_por_estatus');
		$oRdb->setParams($array_params);
		$result = $oRdb->execute();

		if ($result['nCodigo'] == 0) {
			$data = $oRdb->fetchAll();
			$datos = array();
			$index = 0;
			for ($i = 0; $i < count($data); $i++) {
				$datos[$index]["idProveedor"] = $data[$i]["idProveedor"];
				$datos[$index]["RFC"] = $data[$i]["RFC"];
				$datos[$index]["razonSocial"] = utf8_encode($data[$i]["razonSocial"]);
				$datos[$index]["idEstatusProveedor"] = $data[$i]["idEstatusProveedor"];
				if ($data[$i]["nIdTipoCliente"] == 1)
					$datos[$index]["tipo"] = "Integrador";
				else
					$datos[$index]["tipo"] = "Proveedor";
				$index++;
			}
			$oRdb->closeStmt();
			$totalDatos = $oRdb->foundRows();
			$oRdb->closeStmt();
		} else {
			$datos = 0;
			$totalDatos = 0;
		}
		$resultado = array(
			"iTotalRecords"     => $totalDatos,
			"iTotalDisplayRecords"  => $totalDatos,
			"aaData"        => $datos,
			"tipo" 			=> $tipo,
			"perfil" 		=> $perfil
		);
		echo json_encode($resultado);
		break;
}
