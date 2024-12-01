<?php

	/*
		Generar el documento excel de las facturas de proveedores internos y externos
	*/

	include("../../../inc/config.inc.php");
	include("../../../inc/session.ajax.inc.php");
	global $RBD;

	$idCadena			= (isset($_GET['idCadena']) && $_GET['idCadena'] >= 0 && $_GET['idCadena'] != "")? $_GET['idCadena'] : -1;
	$idSubCadena		= (isset($_GET['idSubCadena']) && $_GET['idSubCadena'] >= 0 && $_GET['idSubCadena'] != "")? $_GET['idSubCadena'] : -1;
	$idCorresponsal		= (isset($_GET['idCorresponsal']) && $_GET['idCorresponsal'] >= 0 && $_GET['idCorresponsal'] != "")? $_GET['idCorresponsal'] : -1;

	$tipoDocumento		= (isset($_GET["tipoDocumento"]) && $_GET["tipoDocumento"] != "") ? $_GET["tipoDocumento"]: -1;
	$RFC				= (isset($_GET["RFC"]) && $_GET["RFC"] != "") ? $_GET["RFC"]: "";
	$noFactura			= (isset($_GET["noFactura"]) && $_GET["noFactura"] != "") ? $_GET["noFactura"]: -1;
	$numeroCuenta		= (isset($_GET["numeroCuenta"]) && $_GET["numeroCuenta"] != "") ? $_GET["numeroCuenta"]: -1;
	$fechaFactura		= (isset($_GET["txtFechaFactura"]) && $_GET["txtFechaFactura"] != "") ? $_GET["txtFechaFactura"]: '0000-00-00';
	$fechaInicio		= (isset($_GET["txtFechaIni"]) && $_GET["txtFechaIni"] != "") ? $_GET["txtFechaIni"]: '0000-00-00';
	$fechaFin			= (isset($_GET["txtFechaFin"]) && $_GET["txtFechaFin"] != "") ? $_GET["txtFechaFin"]: '0000-00-00';
	$idEstatus			= (isset($_GET["idEstatus"]) && $_GET["idEstatus"] != "") ? $_GET["idEstatus"]: -1;
	$start				= (isset($_GET["start"]) && $_GET["start"] != "") ? $_GET["start"]: -1;
	$limit				= (isset($_GET["end"]) && $_GET["end"] != "") ? $_GET["end"]: -1;
	$idTipoProveedor	= (isset($_GET["idTipoProveedor"]) && $_GET["idTipoProveedor"] != "") ? $_GET["idTipoProveedor"]: 0;
	$idProveedor		= (!empty($_GET["idProveedor"])) ? $_GET["idProveedor"]: 0;
	$corte				= (isset($_REQUEST['corte']) AND $_REQUEST['corte'] > -1)? $_REQUEST['corte'] : -1;

	$colsort	= (isset($_REQUEST['iSortCol_0']) AND $_REQUEST['iSortCol_0'] > -1)? $_REQUEST['iSortCol_0'] : 0;
	$ascdesc	= (!empty($_REQUEST['sSortDir_0']))? $_REQUEST['sSortDir_0'] : 0;
	$strToFind	= (!empty($_REQUEST['sSearch']))? $_REQUEST['sSearch'] : '';

	//$sql = "CALL data_contable.SP_FACTURAS_CLIENTES_LOAD($tipoDocumento,'$noFactura','$numeroCuenta','$fechaFactura', '$fechaInicio','$fechaFin',$idEstatus, $actual, $cant, $colsort, '$ascdesc', '$strToFind', $idTipoProveedor, 0, $corte, $idCadena, $idSubCadena, $idCorresponsal)";
	$sql = "CALL data_contable.SP_FACTURAS_CLIENTES_LOAD($tipoDocumento,'$noFactura','$numeroCuenta','$fechaFactura', '$fechaInicio','$fechaFin',$idEstatus, $start, $limit, $colsort, '$ascdesc', '$strToFind', $idTipoProveedor, 0, $corte, $idCadena, $idSubCadena, $idCorresponsal, '$RFC')";

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
					<th>Tipo Dcto</th>
					<th>No. Factura/Recibo</th>
					<th>Raz&oacute;n Social</th>
					<th>No. Cuenta</th>
					<th>Fecha Factura/Recibo</th>
					<th>Total</th>
					<th>Estatus</th>
					<th>Detalle</th>
					<th>Corte</th>
				</tr>
			</thead>";

		while($row= mysqli_fetch_assoc($result)){
			$tipoDocumento	= $row['tipoDocumento'];
			$numeroCuenta	= $row['numeroCuenta'];
			$noFactura		= $row['noFactura'];

			echo "<tr>";
				echo "<td>".$row["documento"]."</td>";
				echo "<td>".$row["noFactura"]."</td>";
				echo "<td>".$row["razonSocial"]."</td>";
				echo "<td>".$row["numeroCuenta"]."</td>";
				echo "<td>".$row["fechaFactura"]."</td>";
				echo "<td>".$row["total"]."</td>";
				echo "<td>".$row["estatus"]."</td>";
				echo "<td>".$row["detalle"]."</td>";
				echo "<td>".$row["lblCorte"]."</td>";
			echo "</tr>";
		}
		echo "</table>";
	}
	else{
		echo $RBD->error();
	}
?>