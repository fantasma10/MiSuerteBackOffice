<?php

	include("../../../inc/config.inc.php");
	include("../../../inc/session.ajax.inc.php");
	global $RBD;

	$PATHRAIZ = "https://".$_SERVER['HTTP_HOST'];

	$idPerfil = $_SESSION['idPerfil'];
	$idOpcion = 55;

	$esEscritura = false;
	if(esLecturayEscrituraOpcion($idOpcion)){
		$esEscritura = true;
	}

	function acentos($txt){
		return (!preg_match('!!u', $txt))? utf8_encode($txt) : $txt;
	}

	$tipoDocumento		= (isset($_GET["tipoDocumento"]) && $_GET["tipoDocumento"] != "") ? $_GET["tipoDocumento"]: -1;
	$noFactura			= (isset($_GET["noFactura"]) && $_GET["noFactura"] != "") ? $_GET["noFactura"]: -1;
	$numeroCuenta		= (isset($_GET["numeroCuenta"]) && $_GET["numeroCuenta"] != "") ? $_GET["numeroCuenta"]: -1;
	$fechaFactura		= (isset($_GET["txtFechaFactura"]) && $_GET["txtFechaFactura"] != "") ? $_GET["txtFechaFactura"]: '0000-00-00';
	$fechaInicio		= (isset($_GET["txtFechaIni"]) && $_GET["txtFechaIni"] != "") ? $_GET["txtFechaIni"]: '0000-00-00';
	$fechaFin			= (isset($_GET["txtFechaFinal"]) && $_GET["txtFechaFinal"] != "") ? $_GET["txtFechaFinal"]: '0000-00-00';
	$idEstatus			= (isset($_GET["idEstatus"]) && $_GET["idEstatus"] != "") ? $_GET["idEstatus"]: -1;
	$idTipoProveedor	= (isset($_GET["idTipoProveedor"]) && $_GET["idTipoProveedor"] != "") ? $_GET["idTipoProveedor"]: 0;
	$idProveedor		= (!empty($_GET["idProveedor"])) ? $_GET["idProveedor"]: 0;
	$corte				= (isset($_REQUEST['corte']) AND $_REQUEST['corte'] > -1)? $_REQUEST['corte'] : -1;

	$actual		= (!empty($_REQUEST["iDisplayStart"]))? $_REQUEST["iDisplayStart"] : 0;
	$cant		= (!empty($_REQUEST["iDisplayLength"]))? $_REQUEST["iDisplayLength"] : 20;

	$colsort	= (isset($_REQUEST['iSortCol_0']) AND $_REQUEST['iSortCol_0'] > -1)? $_REQUEST['iSortCol_0'] : 0;
	$ascdesc	= (!empty($_REQUEST['sSortDir_0']))? $_REQUEST['sSortDir_0'] : 0;
	$strToFind	= (!empty($_REQUEST['sSearch']))? $_REQUEST['sSearch'] : '';
	//echo "CALL data_contable.SP_FACTURAS_LOAD($tipoDocumento,'$noFactura','$numeroCuenta','$fechaFactura', '$fechaInicio','$fechaFin',$idEstatus, $actual, $cant, $colsort, '$ascdesc', '$strToFind', $idTipoProveedor, 0, $corte, $idProveedor)";
	if($idTipoProveedor == 0){
		$sql = "CALL data_contable.SP_FACTURAS_LOAD($tipoDocumento,'$noFactura','$numeroCuenta','$fechaFactura', '$fechaInicio','$fechaFin',$idEstatus, $actual, $cant, $colsort, '$ascdesc', '$strToFind', $idTipoProveedor, 0, $corte, $idProveedor)";
	}
	else if($idTipoProveedor == 1){
		$sql = "CALL data_contable.SP_FACTURAS_ACREEDOR_LOAD($tipoDocumento,'$noFactura','$numeroCuenta','$fechaFactura', '$fechaInicio','$fechaFin',$idEstatus, $actual, $cant, $colsort, '$ascdesc', '$strToFind', $idTipoProveedor, 0, $corte, $idProveedor)";
	}

	$result = $RBD->query($sql);

	$fila = 0;

	if(!$RBD->error()){
		while($row = mysqli_fetch_assoc($result)){
			$tipoDocumento	= $row['tipoDocumento'];
			$numeroCuenta	= $row['numeroCuenta'];
			$noFactura		= $row['noFactura'];
			$idFactura		= $row['idFactura'];

			//$asignarFactura = "<a href='#' idfactura='".$row['idFactura']."' total='".$row["total"]."' onclick='asignarFactura(event)'>Asignar</a>";
			$asignarFactura = "<input type='checkbox' class='check' row='".$fila."' idfactura='".$row['idFactura']."' total='".$row["total"]."'>";

			$fila++;

			$ver = (empty($_REQUEST['asignacion']))? "<a href='#ModalEditar' data-toggle='modal' data-keyboard='false' onclick='AbrirDetalleFactura(\"$tipoDocumento\", \"$numeroCuenta\", \"$noFactura\")'> Ver </a>" : $asignarFactura;
			$array = array(
				$row["documento"],
				$row["noFactura"],
				acentos($row["razonSocial"]),
				$row["numeroCuenta"],
				$row["fechaFactura"],
				$row["fechaInicio"],
				$row["fechaFin"],
				"\$".number_format($row["total"], 2),
				$row["estatus"],
				acentos($row["detalle"]),
				$ver,
				$row['lblCorte']
			);

			//contabilidad coordinador
				if($esEscritura){
					if($idPerfil == 3 || $idPerfil == 1){
						if($row['idEstatus'] == 1 && empty($row["idCorte"])){
							$array[] = "<a href='#ModalEditar' data-toggle='modal' data-keyboard='false' onclick='editar($idFactura);'><img src='".$PATHRAIZ."/img/edit.png' title='Editar'></a>";
							$array[] = "<a href='#' onclick='eliminar($idFactura)'><img src='".$PATHRAIZ."/img/delete.png' title='Eliminar'></a>";
						}
						else{
							$array[] = "<img src='".$PATHRAIZ."/img/edit.png' title='Editar' style='opacity:0.4;'>";
							$array[] = "<img src='".$PATHRAIZ."/img/delete.png' title='Eliminar' style='opacity:0.4;'>";
						}
					}//contabilidad base
					elseif($idPerfil == 9){
						if($row['idEstatus'] == 1 && empty($row["idCorte"])){
							$array[] = "<a href='#ModalEditar' data-toggle='modal' data-keyboard='false' onclick='editar($idFactura);'><img src='".$PATHRAIZ."/img/edit.png' title='Editar'></a>";
						}
						else{
							$array[] = "<img src='".$PATHRAIZ."/img/edit.png' title='Editar' style='opacity:0.4;'>";
						}
					}
				}

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
			"aaData"                => $data
		);
	}
	else{
		$output = array(
			"sEcho"					=> 0,
			"iTotalRecords"			=> 0,
			"iTotalDisplayRecords"	=> 0,
			"aaData"				=> array(),
			"errmsg"				=> $RBD->error()
		);
	}

	echo json_encode($output);
?>
