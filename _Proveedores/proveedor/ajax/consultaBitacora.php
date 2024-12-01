<?php 

include($_SERVER['DOCUMENT_ROOT'] . "/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT'] . "/inc/session.ajax.inc.php");

$tipo  = (!empty($_POST["tipo"])) ? $_POST["tipo"] : 1;
// var_dump($_SESSION);
switch ($tipo) {

	case 1:
		$sql = "CALL redefectiva.`sp_select_bitacoraNombreCatalogo`()";
		$result = $oRdb->query($sql);
        // var_dump($result);
		$datos = array();
		$index = 0;
		while ($row = mysqli_fetch_assoc($result)) {
			$datos[$index]["tabla"] = $row["Tabla"];
			$datos[$index]["catalogo"] = utf8_encode($row["Catalogo"]);
			$index++;
		}
		print json_encode($datos);
		break;

	case 2:
		$date = date('Y-m-d');
		$mesAnterior = date('Y-m-d', strtotime('-1 month'));
		$sql = "CALL redefectiva.`sp_select_bitacora_cambios`('$mesAnterior','$date', -1,'','','')";
		$result = $oRdb->query($sql);
		$datos = array();
		$index = 0;
		while ($row = mysqli_fetch_assoc($result)) {
			$datos[$index]["id"] = $row["IdRegistro"];
			$datos[$index]["usuario"] = $row["IdUsuario"];
			$datos[$index]["catalogo"] = utf8_encode($row["Tabla"]);
			$datos[$index]["fechMovimiento"] = $row["FechaRegistro"];
			$datos[$index]["tipoAccion"] = utf8_encode($row["Accion"]);
			$datos[$index]["ultimosCambios"] = utf8_encode($row["JSON"]);
			$index++;
		}
		print json_encode($datos);
		break;

	case 3:
		$fechaInicial = $_POST['fechaInicial'];
		$fechaFinal = $_POST['fechaFinal'];
		$tipoAccion = $_POST['tipoAccion'];
		$idregistro = $_POST['txtregistro'];
		$usuario = ($_POST["opcionUsuarios"]) ? $_POST["opcionUsuarios"] : '-1';
		$opcionCatalogo = $_POST['opcionCatalogo'];

		$sql = "CALL redefectiva.`sp_select_bitacora_cambios`('$fechaInicial','$fechaFinal', $usuario, '$tipoAccion', '$idregistro', '$opcionCatalogo')";
		$result = $oRdb->query($sql);
		$datos = array();
		$index = 0;
		while ($row = mysqli_fetch_assoc($result)) {
			$datos[$index]["id"] = $row["IdRegistro"];
			$datos[$index]["usuario"] = $row["IdUsuario"];
			$datos[$index]["catalogo"] = utf8_encode($row["Tabla"]);
			$datos[$index]["fechMovimiento"] = $row["FechaRegistro"];
			$datos[$index]["tipoAccion"] = utf8_encode($row["Accion"]);
			$datos[$index]["ultimosCambios"] = utf8_encode($row["JSON"]);
			$index++;
		}
		print json_encode($datos);
		break;
	case 4:
		$idRegistro = $_POST['idRegistro'];
		$catalogo = $_POST['catalogo'];

		$sql = "CALL redefectiva.`sp_select_bitacora_ultimoCambio`('$idRegistro', '$catalogo')";
		$result = $oRdb->query($sql);
		$datos = array();
		$index = 0;
		while ($row = mysqli_fetch_assoc($result)) {
			$datos[$index]["id"] = $row["Id"];
			$datos[$index]["usuario"] = $row["Usuario"];
			$datos[$index]["fechMovimiento"] = $row["Fecha registro"];
			$datos[$index]["catalogo"] = utf8_encode($row["Tabla"]);
			$datos[$index]["tipoAccion"] = utf8_encode($row["Accion"]);
			$datos[$index]["ultimosCambios"] = utf8_encode($row["JSON"]);
			$index++;
		}
		print json_encode($datos);
		break;

	case 5:
		$options = array(
			'http' => array(
				'method' => 'GET',
				'header' => 'Content-type: application/json\r\nAuthorization: Bearer YOUR_ACCESS_TOKEN',
				'timeout' => 20,
			),
		);

		$context = stream_context_create($options);
		$response = file_get_contents($webService_users, false, $context);
		$index = 0;
		$datos = array();
		$data = json_decode($response, true);

		foreach ($data['Usuarios'] as $usuario) {
			$datos[$index]["id"] = $usuario["Id"];
			$datos[$index]["nombre"] = $usuario["Nombre"];
			$datos[$index]["apellidoPaterno"] = $usuario["ApellidoPaterno"];
			$datos[$index]["apellidoMaterno"] = $usuario["ApellidoMaterno"];
			$datos[$index]["nombreCompleto"] = $usuario["NombreCompleto"];
			$datos[$index]["Correo"] = $usuario["Correo"];
			$index++;
		}
		print json_encode($datos);

		break;
}

?>