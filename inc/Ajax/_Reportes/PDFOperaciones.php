<?php
	/*error_reporting(E_ALL);
	ini_set('display_errors', 1);*/
	//ini_set('memory_limit', '512M');
	/*
	********** ARCHIVO QUE ESPECIFICA LAS CABECERAS Y EL QUERY PARA CREAR EL ARCHIVO .PDF **********
	*/
	include("../../config.inc.php");
	include("../../session.ajax.inc.php");
	$tipoDePagina = "Lectura";
	$idOpcion = 10;
	if ( !desplegarPagina($idOpcion, $tipoDePagina) ) {
		header("Location: ../../../error.php");
	    exit();
	}

	$seccion  = "Operaciones";
	//codigo del departamento
	$departamento = "DOP";
	//tipo de documento
	$tipodocumento = "IF";
	//consecutivo del documento
	$consecutivo = "01";
	include("../../../tcpdf/PDFP.php");

	$idCad			= (isset($_POST["ddlCad"]) && $_POST["ddlCad"] != "")? $_POST["ddlCad"] : -1;
	$idSubCad		= (isset($_POST["ddlSubCad"]) && $_POST["ddlSubCad"] != "")? $_POST["ddlSubCad"] : -1;
	$ddlCorresponsal= (isset($_POST["ddlCorresponsal"]) && $_POST["ddlCorresponsal"] != "")? $_POST["ddlCorresponsal"] : -1;
	$txtId			= (!empty($_POST["txtId"]))? $_POST["txtId"] : -1;
	$familia		= (!empty($_POST["ddlFam"]))? $_POST["ddlFam"] : -1;
	$subfamilia		= (!empty($_POST["ddlSubFam"]))? $_POST["ddlSubFam"] : -1;
	$proveedor		= (!empty($_POST["ddlProveedor"]))? $_POST["ddlProveedor"] : -1;
	$emisor			= (!empty($_POST["ddlEmisor"]))? $_POST["ddlEmisor"] : -1;
	$fecha1			= (!empty($_POST["fecha1"]))? $_POST["fecha1"] : -1;
	$fecha2			= (!empty($_POST["fecha2"]))? $_POST["fecha2"] : -1;
	$cant			= (!empty($_POST["cpag"]))? $_POST["cpag"] : -1;
	$actual			= (!empty($_POST["actual"]))? $_POST["actual"] : -1;
	$lbls			= (!empty($_POST["labels"]))? $_POST["labels"] : "";
	$values			= (!empty($_POST["values"]))? $_POST["values"] : "";
	$todos			= (!empty($_POST["todos"]))? $_POST["todos"] : "";
	$totalReg		= (!empty($_POST["totalreg"]))? $_POST["totalreg"] : "";

	if ( empty($todos) ) {
		$actual = ($actual != "undefined")? $actual : 0;
		if($actual > 0){
			$actual = $actual * $cant - $cant;
		}
	} else {
		$actual = 0;
	}

	if($ddlCorresponsal == -2 AND $idSubCad == -2 && $idCad == -2){
		$idCorresponsal = $txtId;
	}
	else{
		$idCorresponsal = $ddlCorresponsal;
	}

	$limite = $cant;
	if ( !empty($todos) ) {
		$limite = $totalReg;
	}

	$RBD->query("SET NAMES 'utf8'");
	
	if ( $limite >= 100 ) {
		$sql = "CALL redefectiva.SP_BUSCA_OPERACIONES_FILTROS($idCad, $idSubCad, $idCorresponsal, $familia, $subfamilia, $proveedor, $emisor, '$fecha1', '$fecha2', $actual, 100);";
	} else {
		$sql = "CALL redefectiva.SP_BUSCA_OPERACIONES_FILTROS($idCad, $idSubCad, $idCorresponsal, $familia, $subfamilia, $proveedor, $emisor, '$fecha1', '$fecha2', $actual, $limite);";
	}
	//var_dump($sql);
	$res = $RBD->query($sql);

	if(!$RBD->error()){

		$rows = array();
		while($row = mysqli_fetch_assoc($res)){
			$rows[] = $row;
		}

		$arrTable = array(
			"mainHead"		=>	"Lista de Operaciones",
			"headers"		=>	array("Folio","No Cta","Referencia","Fec. Solic.","Fec. Aplic.","Operador","Autorizacion","Estatus","Proveedor","Producto","Importe"),
			"rows"			=>	$rows,
			"indexes"		=>	array("idsOperacion", "numCuenta", "referencia1Operacion", "fecSolicitudOperacion", "fecAplicacionOperacion", "idOperador", "autorizacionOperacion", "lblEstatus", "nombreProveedor", "descProducto", "importeOperacion"),
			"formats"		=>	array("","","","","","","","","","", "money"),
			"filtersHead"	=>	explode(",", $lbls),
			"filtersValue"	=>	explode(",", $values)
		);
		
		if(count($rows)>0){
			unset($rows);
			include("../../../pdf/crearTblPdf.php");
			$html = $tbl;
		}
		else{
			$html .= "<h2>No se encontraron Operaciones</h2>";
		}
	}
	else{
		$html = $RBD->error();
	}
	/*echo "<pre>";
	print_r($arrTable);
	echo "</pre>";*/
	$pdf->writeHTML($html, false, false, false, false, '');
	$pdf->Output();
?>