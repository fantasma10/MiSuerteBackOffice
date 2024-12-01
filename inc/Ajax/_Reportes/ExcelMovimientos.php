<?php
/*
	********** ARCHIVO QUE ESPECIFICA LAS CABECERAS Y EL QUERY PARA CREAR EL ARCHIVO .CSV DESCARGABLE **********
*/
include("../../config.inc.php");
include("../../session.ajax.inc.php");

/* recibimos los parametros por post, vienen en formato como si se hubieran pasado por la url proveedor=1&familia=2&... */
$parametros = (!empty($_POST["params_excel"]))? $_POST["params_excel"] : "";

/* si se recibieron parametros, se separan por el & */
if(!empty($parametros)){
	$parametros = explode("&", $parametros);
	/* arreglo para guardar los parámetros */
	$params = array();
	
	/*	recorrer el arreglo $parametros y cada elemento separarlo por el =
		el primer valor será el indice que se guardará en el arreglo $params y el segundo el contenido
		valores usados actualmente : 
		nocuenta
		tipoM
		idcorresponsal
		fecha1	: fecha inicial
		fecha2	: fecha final
		opPag	: operaciones a mostrar por página
		actual	: pagina actual del reporte
		todos	: bandera para saber si se generará el excel paginado o sin paginar
	*/
	foreach($parametros as $param){
		$exp = explode("=", $param);
		$key = current($exp);
		$value = end($exp);

		$params[$key] = $value;
	}

	/* arreglo con configuración e información para la tabla html exportada a excel que se generará con el archivo exportExcel.php */
	$arrTable = array(
		"mainHead"	=> "Movimientos",
		"headers"	=> array("Id. Mov", "Referencia", "Fec. Aplic", "Com. Corresponsal", "Tipo Movimiento", "Cargo", "Abono", "Saldo Final"),
		"indexes"	=> array("idsMovimiento", "idsOperacion", "fecAppMov", "comCorresponsal", "descTipoMovimiento", "cargoMov", "abonoMov", "saldoFinal"),
		"formats"	=> array("", "", "", "money", "", "money", "money", "money")
	);

	/* llamar stored procedure para obtener las filas con la información */
	if(!empty($params["todos"])){
		$start = 0;
		$limit = $params["totalReg"];
	}
	else{
		$limit = $params["opPag"];
		$start = 0;
		if($params["actual"]>1){
			$start = ($params["actual"] -1) * $params["opPag"];
		}
	}

	$numCuenta = ($params["nocuenta"] != "")? $params["nocuenta"] : 0;
	$idCadena = ($params["idcadena"] != "")? $params["idcadena"] : 0;
	$idSubCadena = ($params["idsubcadena"] != "")? $params["idsubcadena"] : 0;
	$idCorresponsal = ($params["idcorresponsal"] != "")? $params["idcorresponsal"] : 0;
	
	//$res  = $RBD->SP("call SP_LOAD_MOVIMIENTOS($numCuenta, $idCorresponsal, '$params[fecha1]', '$params[fecha2]', $params[tipoM], $start, $limit)");

	$res = $RBD->SP("CALL `redefectiva`.`SP_LOAD_MOVIMIENTOS`($numCuenta, $idCadena, $idSubCadena, $idCorresponsal, '$params[fecha1]', '$params[fecha2]', $params[tipoM], $start, $limit, @codigoRespuesta, @totalRegistros);");

	//var_dump("CALL `redefectiva`.`SP_LOAD_MOVIMIENTOS`($numCuenta, $idCadena, $idSubCadena, $idCorresponsal, '$params[fecha1]', '$params[fecha2]', $params[tipoM], $start, $limit, @codigoRespuesta, @totalRegistros);");

	if($idCorresponsal > 0){
		$sC = $RBD->query("call SPA_LOADCORRESPONSAL($idCorresponsal)");
		$rC = mysqli_fetch_array($sC);
		$arrTable["filtersHead"][] = "Corresponsal";
		$arrTable["filtersValue"][] = $rC["nombreCorresponsal"];
	}

	if($numCuenta > 0){
		$arrTable["filtersHead"][] = "Cuenta :";
		$arrTable["filtersValue"][] = $numCuenta;
	}

	$arrTable["filtersHead"][] = "Periodo";
	$arrTable["filtersValue"][] = "De ".$params["fecha1"]." a ".$params["fecha2"];

	$arrTable["filtersHead"][] = "Página";
	$arrTable["filtersValue"][] = $params["actual"];

	while($row = mysqli_fetch_array($res)){
		$arrTable["rows"][] = $row;
	}
	
	/* incluimos el archivo que genera la tabla html y lo exporta a excel */
	include("../../../excel/exportExcel.php");
	}
?>