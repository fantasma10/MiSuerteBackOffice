<?php
ini_set("soap.wsdl_cache_enabled", "0");
include($_SERVER['DOCUMENT_ROOT'] . "/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT'] . "/inc/session2.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT'] . "/inc/customFunctions.php");

/*
case 1  selecciona la lista de emisores
*/

$tipo  = (!empty($_POST["tipo"])) ? $_POST["tipo"] : 0;
$perfil = (!empty($_POST["perfil"])) ? $_POST["perfil"] : 1; //1 administrador

function guardarDatosEmisor($e_idemisor, $abreviaturaEmisor, $descripcionEmisor, $opcionEstastus, $idUsuario)
{
	$datos = array();
	$query = '';

	$query = "CALL `redefectiva`.`sp_update_emisores_multipagos`(
		$e_idemisor,
	    '$abreviaturaEmisor',
	    '$descripcionEmisor',
	    $opcionEstastus,
	    $idUsuario
	);";

	$resultado = $GLOBALS['oWdb']->query($query);

	if (!$resultado) {
		$datos["code"] = "99";
		$datos["msg"] = "Error al generar el proceso";
		return $datos; // Salir inmediatamente en caso de error
	}

	$datos["code"] = "0";
	$datos["msg"] = "Proceso exitoso";

	return $datos;
}

function obtenerDatosEmisor($idEmisor)
{
    $query = "CALL `redefectiva`.`sp_obtener_emisor_multipagos`($idEmisor);";

    $resultado = $GLOBALS['oWdb']->query($query);

    if (!($resultado)) {
        $datos = null;
    } else {
        $datos = mysqli_fetch_assoc($resultado);
    }

    return $datos;
}

function actualizarEstatusEmisor($idEmisor, $estatus)
{
    $query = "CALL `redefectiva`.`sp_actualizar_estatus_emisor_multipagos`($idEmisor, $estatus);";

    $resultado = $GLOBALS['oWdb']->query($query);

    if (!$resultado) {
		$datos["code"] = "99";
		$datos["msg"] = "Error al generar el proceso";
		return $datos; // Salir inmediatamente en caso de error
	}

	$datos["code"] = "0";
	$datos["msg"] = "Proceso exitoso";

    return $datos;
}

switch ($tipo) {
	case 1:

		$oRdb->setSDatabase('redefectiva');
		$oRdb->setSStoredProcedure('sp_select_emisores_multipagos');
		$result = $oRdb->execute();

		if ($result['nCodigo'] == 0) {
			$data = $oRdb->fetchAll();
			$datos = array();
			$index = 0;
			for ($i = 0; $i < count($data); $i++) {
				$datos[$index]["idEmisor"] = $data[$i]["idEmisor"];
				$datos[$index]["descEmisor"] = utf8_encode($data[$i]["descEmisor"]);
				$datos[$index]["abrevNomEmivosr"] = utf8_encode($data[$i]["abrevNomEmivosr"]);
				$datos[$index]["idEstatusEmisor"] = $data[$i]["idEstatusEmisor"];
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

		$p_estatus = $_POST["estatus"];
		$array_params = array(array('name' => 'p_estatus', 'value' => $p_estatus, 'type' => 'i'));

		$oRdb->setSDatabase('redefectiva');
		$oRdb->setSStoredProcedure('sp_estatus_emisores_multipagos');
		$oRdb->setParams($array_params);
		$result = $oRdb->execute();

		if ($result['nCodigo'] == 0) {
			$data = $oRdb->fetchAll();
			$datos = array();
			$index = 0;
			for ($i = 0; $i < count($data); $i++) {
				$datos[$index]["idEmisor"] = $data[$i]["idEmisor"];
				$datos[$index]["descEmisor"] = utf8_encode($data[$i]["descEmisor"]);
				$datos[$index]["abrevNomEmivosr"] = utf8_encode($data[$i]["abrevNomEmivosr"]);
				$datos[$index]["idEstatusEmisor"] = $data[$i]["idEstatusEmisor"];
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

	case 3:
		$e_idemisor        = $_POST["e_idemisor"];
		$idUsuario         = $_POST['idUsuario'];
		$abreviaturaEmisor = $_POST['abreviatura'];
		$descripcionEmisor = $_POST['descripcion'];
		$opcionEstastus    = $_POST['opcionEstastus'];

		$datos = guardarDatosEmisor($e_idemisor, $abreviaturaEmisor, $descripcionEmisor, $opcionEstastus, $idUsuario);
		echo json_encode($datos);
		break;
	case 4:
		$e_idemisor        = $_POST["e_idemisor"];
		$datos = obtenerDatosEmisor($e_idemisor);
		echo json_encode($datos);
		break;
	case 5:
		$idEmisorModal        = $_POST["idEmisorModal"];
		$estatus        = $_POST["estatus"];
		// var_dump($idEmisorModal);
		$datos = actualizarEstatusEmisor($idEmisorModal, $estatus);
		echo json_encode($datos);
		break;

	default:
		# code...
		break;
}
