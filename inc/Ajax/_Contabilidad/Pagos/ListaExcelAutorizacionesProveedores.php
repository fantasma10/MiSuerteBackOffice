<?php

	/*
		Generar el documento excel de las facturas de proveedores internos y externos
	*/

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
	global $RBD;

	$tipoPago		= ($_GET["tipoPago"] != "") ? $_GET["tipoPago"]: -1;
	$noFactura		= ($_GET["noFactura"] != "") ? $_GET["noFactura"]: '';
	$fechaFactura	= ($_GET["txtFechaFactura"] != "") ? $_GET["txtFechaFactura"]: '0000-00-00';
	$RFC			= ($_GET["RFC"] != "") ? $_GET["RFC"]: '';
	$numeroCuenta	= ($_GET["numeroCuenta"] != "") ? $_GET["numeroCuenta"]: '';
	$idEstatus		= ($_GET["idEstatus"] != "") ? $_GET["idEstatus"]: -1;

	$start = ($_GET["start"] != "") ? $_GET["start"]: -1;
	$limit = ($_GET["end"] != "") ? $_GET["end"]: 10;

	$colsort	= (isset($_REQUEST['iSortCol_0']) AND $_REQUEST['iSortCol_0'] > -1)? $_REQUEST['iSortCol_0'] : 0;
	$ascdesc	= (!empty($_REQUEST['sSortDir_0']))? $_REQUEST['sSortDir_0'] : 0;
	$strToFind	= (!empty($_REQUEST['sSearch']))? $_REQUEST['sSearch'] : '';

	$sql = "CALL data_contable.SP_AUTORIZACION_PROVEEDORES_LOAD($tipoPago, '$noFactura', '$fechaFactura', '$RFC', '$numeroCuenta', $idEstatus, $start, $limit, $colsort, '$ascdesc', '$strToFind')";
	$result = $RBD->query($sql);

	if(!$RBD->error()){

		header('Content-Description: File Transfer');
		header('Content-Type=application/x-msdownload');
		header('Content-disposition:attachment;filename=Facturas-Recibos.xls');
		header("Pragma:no-cache");
		header("Set-Cookie: fileDownload=true; path=/");

		echo "<table>";
		echo "<thead>
				<tr>
					<th>Tipo</th>
					<th>Documento</th>
					<th>#</th>
					<th>Importe Original</th>
					<th>Importe Solicitado</th>
					<th>Importe Diferencia</th>
					<th>Descripci&oacute;n</th>
				</tr>
			</thead>";

		while($row = mysqli_fetch_assoc($result)){
			echo "<tr>";
				echo "<td>".acentos($row["descTipoCortePago"])."</td>";
				echo "<td>".acentos($row["nombreDocumento"])."</td>";
				echo "<td>".acentos($row["noFactura"])."</td>";
				echo "<td>\$".number_format($row["importeOriginal"], 2)."</td>";
				echo "<td>\$".number_format($row["importeSolicitado"], 2)."</td>";
				echo "<td>\$".number_format($row["importeDiferencia"], 2)."</td>";
				echo "<td>".acentos($row["descripcion"])."</td>";
			echo "</tr>";
		}
		echo "</table>";
	}
	else{
		echo $RBD->error();
	}

	function acentos($txt){
		return (!preg_match('!!u', $txt))? utf8_encode($txt) : $txt;
	}
?>