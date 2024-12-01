<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");


	$idPerfil = $_SESSION['idPerfil'];
	$idOpcion = 59;

	$esEscritura = false;
	if(esLecturayEscrituraOpcion($idOpcion)){
		$esEscritura = true;
	}

	function acentos($txt){
		return (!preg_match('!!u', $txt))? utf8_encode($txt) : $txt;
	}

	$tipoPago		= ($_GET["tipoPago"] != "") ? $_GET["tipoPago"]: -1;
	$noFactura		= ($_GET["noFactura"] != "") ? $_GET["noFactura"]: '';
	$fechaFactura	= ($_GET["txtFechaFactura"] != "") ? $_GET["txtFechaFactura"]: '0000-00-00';
	$RFC			= ($_GET["RFC"] != "") ? $_GET["RFC"]: '';
	$numeroCuenta	= ($_GET["numeroCuenta"] != "") ? $_GET["numeroCuenta"]: '';
	$idEstatus		= ($_GET["idEstatus"] != "") ? $_GET["idEstatus"]: -1;

	$actual		= (!empty($_REQUEST["iDisplayStart"]))? $_REQUEST["iDisplayStart"] : 0;
	$cant		= (!empty($_REQUEST["iDisplayLength"]))? $_REQUEST["iDisplayLength"] : 20;

	$colsort	= (isset($_REQUEST['iSortCol_0']) AND $_REQUEST['iSortCol_0'] > -1)? $_REQUEST['iSortCol_0'] : 0;
	$ascdesc	= (!empty($_REQUEST['sSortDir_0']))? $_REQUEST['sSortDir_0'] : 0;
	$strToFind	= (!empty($_REQUEST['sSearch']))? $_REQUEST['sSearch'] : '';

	$sql = $RBD->query("SELECT GROUP_CONCAT(U.`idUsuarioAutorizador`) AS `idautorizador`, GROUP_CONCAT(U.`idUsuario`) AS `usuarios`, U.`idTipoCortePago`
			FROM `redefectiva`.`inf_usuarioautorizador` AS U WHERE U.`idTipoCortePago` = 1 AND U.`idEstatus` = 0 GROUP BY `idTipoCortePago`");

	$row = mysqli_fetch_assoc($sql);

	$autorizadores	= explode(",", $row['usuarios']);
	$idAut			= explode(",", $row['idautorizador']);

	$sql = "CALL data_contable.SP_AUTORIZACION_PROVEEDORES_LOAD($tipoPago, '$noFactura', '$fechaFactura', '$RFC', '$numeroCuenta', $idEstatus, $actual, $cant, $colsort, '$ascdesc', '$strToFind')";
	$result = $RBD->query($sql);

	$errmsg = $RBD->error();

	$idUsuario = $_SESSION['idU'];

	while($row = mysqli_fetch_assoc($result)){

		$autorizar = " - ";

		if($esEscritura){
			if(in_array($idUsuario, $autorizadores)){
	
				$index = array_search($idUsuario, $autorizadores);
 
				$idUsuarioAutorizador = $idAut[$index];

				$idDocumento = $row['idFacturas'];

				if(($idPerfil == 3 || $idPerfil == 1) && $row['idEstatus'] == 1){
					$autorizar = "<a href='#ModalEditar' data-toggle='modal' idDocumento='".$idDocumento."' tipocorte='".$row['idTipoCortePago']."' onclick='abrirDetalle(event);'>
					<img src='../../../img/ico_revision2.png' data-original-title='Autorizar' idautorizacion='".$row['idAutorizacion']."'idDocumento='".$idDocumento."' tipocorte='".$row['idTipoCortePago']."' numCuenta='".$row['numCuenta']."' noFactura='".$row['noFactura']."' tipoDocumento='".$row['tipoDocumento']."' origenDocumento='".$row['origenDocumento']."' nombreDocumento='".$row['nombreDocumento']."' idusuarioautorizador='".$idUsuarioAutorizador."'>
					</a>";
				}
				else{
					$autorizar = "";
				}
			}
		}

		$array = array(
			acentos($row["descTipoCortePago"]),
			acentos($row["nombreDocumento"]),
			acentos($row["noFacturas"]),
			"\$".number_format($row["importeOriginal"], 2),
			"\$".number_format($row["importeSolicitado"], 2),
			"\$".number_format($row["importeDiferencia"], 2),
			acentos($row["descripcion"]),
			acentos($row["descEstatus"]),
			$autorizar
		);

		$data[] = $array;
	}

	$sqlcount = $RBD->query("SELECT FOUND_ROWS() AS total");
	$res = mysqli_fetch_assoc($sqlcount);
	$iTotal = $res["total"];
	if($iTotal == 0){
		$data = array();
	}
	$iTotalDisplayRecords = ($iTotal < $cant)? $iTotal : $cant;
	$output = array(
		"sEcho"                 => intval($_GET['sEcho']),
		"iTotalRecords"         => $iTotal,
		"iTotalDisplayRecords"  => $iTotal,
		"aaData"                => $data,
		"errmsg"				=> $errmsg
	);

	echo json_encode($output);
?>
