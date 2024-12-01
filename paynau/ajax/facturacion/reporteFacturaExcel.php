<?php
	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.inc.php");
	
	
	$fechaIni = !empty($_POST['fechaIni_excel']) ? $_POST['fechaIni_excel']: '' ;
	$fechaFin = !empty($_POST['fechaFin_excel']) ? $_POST['fechaFin_excel']: '' ;
	$nIdProveedor = !empty($_POST["nIdProveedor_excel"]) ? $_POST["nIdProveedor_excel"]: 0 ;
	$nIdEmpresa = !empty($_POST["nIdEmpresa_excel"]) ? $_POST["nIdEmpresa_excel"]: 0 ;

	if ($nIdProveedor > 0) {
		$Emisor = 'POR UNIDAD DE NEGOCIO';
	}
	elseif ($nIdEmpresa > 0) {
		$Emisor = 'POR EMPRESA';		
	}
	else{
		$Emisor = 'GENERAL';
	}

	header("Content-type=application/x-msdownload; charset=UTF-8");
	header("Content-disposition:attachment;filename=ReporteFoliosPayNau.xls");
	header("Pragma:no-cache");
	header("Expires:0");
	echo "\xEF\xBB\xBF";
	echo $out;

	if ( !empty($fechaIni) && !empty($fechaFin) ) {
		$array_params = array(
            array('name' => 'PO_nIdProveedor', 'value' => $nIdProveedor, 'type' =>'i'),
            array('name' => 'PO_nIdEmpresa', 'value' => $nIdEmpresa, 'type' =>'i'),
            array('name' => 'PO_dFechaInicial', 'value' => $fechaIni, 'type' =>'s'),
            array('name' => 'PO_dFechaFinal', 'value' => $fechaFin, 'type' =>'s')
        );
		
		$oRDPN->setSDatabase('facturacion');
		$oRDPN->setSStoredProcedure('sp_select_facturas_back_office');
		$oRDPN->setParams($array_params);
		$result = $oRDPN->execute();

	    if ( $result['nCodigo'] ==0){			
	    	$c = "<table >";
	    	$c .= "<thead>";
	    	$c .= "<tr><th colspan='7'>RED EFECTIVA, S.A. DE C.V</th></tr>";
	    	$c .= "<tr><th colspan='7'>Reporte del Sistema: PayNau</th></tr>";
	    	$c .= "<tr><th colspan='7'>REPORTE DE FACTURAS TIMBRADAS ($Emisor)</th></tr>";
	    	$c .= "<tr><th colspan='7'>PERIODO DE: $fechaIni AL $fechaFin</th></tr>";
	    	$c .= "<tr><th></th></tr>";
	    	$c .= "<tr>";
	    	$c .= "<th>Razon Social Emisor</th>";
	    	$c .= "<th>RFC Emisor</th>";
	    	$c .= "<th>Folio fiscal</th>";
	    	$c .= "<th>Fecha timbrado</th>";
	    	$c .= "<th>Monto total</th>";
	    	$c .= "<th>Razon Social Receptor</th>";
	    	$c .= "<th>RFC del Receptor</th>";
	    	$c .= "</tr>";
	    	$c .= "</thead>";
	    	$c .= "<tbody>";

	    	$data = $oRDPN->fetchAll();
			for($i=0;$i<count($data);$i++){

				$d .= "<tr border='1'>";
				$d .= "<td>".$data[$i]['RAZONSOCIAL']."</td>";
				$d .= "<td>".$data[$i]['RFC']."</td>";
				$d .= "<td>".$data[$i]['strFolioFiscal']."</td>";
				$d .= "<td>".$data[$i]['dPeticion']."</td>";
				$d .= "<td>".'$'.$data[$i]['totTotal']."</td>";
				$d .= "<td>".$data[$i]['strRazonSocial']."</td>";
				$d .= "<td>".$data[$i]['strRFC']."</td>";
				$d .= "</tr>";
			}
			$d .= "</tbody>";
			$d .= "</table>";
			echo $c;
			echo utf8_encode($d);

			$oRDPN->closeStmt();
			$totalDatos = $oRDPN->foundRows();
			$oRDPN->closeStmt();
	    }else{
	    	echo "Lo sentimos, no se han encontrado registros para su consulta";
	    }		
	}	
?>
