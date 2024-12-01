<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
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

	$idGrupo			= (isset($_GET['idGrupo']) && $_GET['idGrupo'] >= 0 && $_GET['idGrupo'] != "")? $_GET['idGrupo'] : -1;
	$tipoDocumento		= (isset($_GET["tipoDocumento"]) && $_GET["tipoDocumento"] != "") ? $_GET["tipoDocumento"]: -1;
	$RFC				= isset($_GET["RFC"]) && ($_GET["RFC"] != "") ? $_GET["RFC"]: '';
	$noFactura			= (isset($_GET["noFactura"]) && $_GET["noFactura"] != "") ? $_GET["noFactura"]: -1;
	$numeroCuenta		= (isset($_GET["numeroCuenta"]) && $_GET["numeroCuenta"] != "") ? $_GET["numeroCuenta"]: -1;
	$fechaFactura		= (isset($_GET["txtFechaFactura"]) && $_GET["txtFechaFactura"] != "") ? $_GET["txtFechaFactura"]: '0000-00-00';
	$fechaInicio		= (isset($_GET["txtFechaIni"]) && $_GET["txtFechaIni"] != "") ? $_GET["txtFechaIni"]: '0000-00-00';
	$fechaFin			= (isset($_GET["txtFechaFinal"]) && $_GET["txtFechaFinal"] != "") ? $_GET["txtFechaFinal"]: '0000-00-00';
	$idEstatus			= (isset($_GET["idEstatus"]) && $_GET["idEstatus"] >= 0) ? $_GET["idEstatus"]: -1;
	$idTipoProveedor	= (isset($_GET["idTipoProveedor"]) && $_GET["idTipoProveedor"] != "") ? $_GET["idTipoProveedor"]: 0;
	$idProveedor		= (!empty($_GET["idProveedor"])) ? $_GET["idProveedor"]: 0;
	$corte				= (isset($_REQUEST['corte']) AND $_REQUEST['corte'] > -1)? $_REQUEST['corte'] : -1;

	$actual		= (!empty($_REQUEST["iDisplayStart"]))? $_REQUEST["iDisplayStart"] : 0;
	$cant		= (!empty($_REQUEST["iDisplayLength"]))? $_REQUEST["iDisplayLength"] : 20;

	$colsort	= (isset($_REQUEST['iSortCol_0']) AND $_REQUEST['iSortCol_0'] > -1)? $_REQUEST['iSortCol_0'] : 0;
	$ascdesc	= (!empty($_REQUEST['sSortDir_0']))? $_REQUEST['sSortDir_0'] : 0;
	$strToFind	= (!empty($_REQUEST['sSearch']))? $_REQUEST['sSearch'] : '';

	$sql = "CALL data_contable.SP_FACTURAS_GRUPOS_LOAD($tipoDocumento,'$noFactura','$numeroCuenta','$fechaFactura', '$fechaInicio','$fechaFin',$idEstatus, $actual, $cant, $colsort, '$ascdesc', '$strToFind', $idTipoProveedor, 0, $corte, $idGrupo, '$RFC')";
	//var_dump("sql: $sql");
	$result = $RBD->query($sql);

	$errmsg = $RBD->error();

	while($row = mysqli_fetch_assoc($result)){
		$tipoDocumento	= $row['tipoDocumento'];
		$numeroCuenta	= $row['numeroCuenta'];
		$noFactura		= $row['noFactura'];
		$idFactura		= $row['idFactura'];

		//$asignarFactura = "<a href='#' idfactura='".$row['idFactura']."' total='".$row["total"]."' onclick='asignarFactura(event)'>Asignar</a>";
		$asignarFactura = "<input type='checkbox' class='check' row='".$fila."' idfactura='".$row['idFactura']."' total='".$row["total"]."'>";

		$ver = (empty($_REQUEST['asignacion']))? "<a href='#ModalEditar' data-toggle='modal' data-keyboard='false' idfactura='".$row['idFactura']."' onclick='AbrirDetalleFactura(\"$tipoDocumento\", \"$numeroCuenta\", \"$noFactura\")'> Ver </a>" : $asignarFactura;
		$array = array(
			$row["documento"],
			$row["noFactura"],
			acentos($row["razonSocial"]),
			$row["numeroCuenta"],
			$row["fechaFactura"],
			"\$".number_format($row["total"], 2),
			$row["estatus"],
			acentos($row["detalle"]),
			$ver,
			$row['lblCorte']
		);

		//contabilidad coordinador
			if($esEscritura){
				if($idPerfil == 3 || $idPerfil == 1){
					if($row['idEstatus'] == 1 && empty($row['idCorte'])){
						$array[] = "<a href='#ModalEditar' data-toggle='modal' data-keyboard='false' onclick='editar($idFactura);'><img src='".$PATHRAIZ."/img/edit.png' title='Editar'></a>";
						$array[] = "<a href='#' onclick='eliminar($idFactura)'><img src='".$PATHRAIZ."/img/delete.png' title='Eliminar'></a>";
					}
					else{
						$array[] = "<img src='".$PATHRAIZ."/img/edit.png' title='Editar' style='opacity: 0.4;'>";
						$array[] = "<img src='".$PATHRAIZ."/img/delete.png' title='Eliminar' style='opacity: 0.4;'>";
					}
				}//contabilidad base
				elseif($idPerfil == 9){
					if($row['idEstatus'] == 1 && empty($row['idCorte'])){
						$array[] = "<a href='#ModalEditar' data-toggle='modal' data-keyboard='false' onclick='editar($idFactura);'><img src='".$PATHRAIZ."/img/edit.png' title='Editar'></a>";
					}
					else{
						$array[] = "<img src='".$PATHRAIZ."/img/edit.png' title='Editar' style='opacity:0.4;'>";
					}
				}
			}
			else{
				$array[] = "";
				$array[] = "";
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
		"aaData"                => $data,
		"errmsg"				=> $errmsg
	);

	echo json_encode($output);
?>
