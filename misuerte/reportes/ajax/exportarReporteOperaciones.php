<?php
	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.inc.php");
	
        $textomPago = !empty($_POST["textoMPago"]) ? $_POST["textoMPago"] : "Todos";
        $fechaIni   = (!empty($_POST["fecha1_excel"]))  ? $_POST["fecha1_excel"] : date("Y-m-d");
        $fechaFin   = (!empty($_POST["fecha2_excel"]))  ? $_POST["fecha2_excel"] : date("Y-m-d");
        $metodoPago = (!empty($_POST["mPago_excel"]))   ? $_POST["mPago_excel"]  : 0;
	header("Content-type=application/x-msdownload; charset=UTF-8");
	header("Content-disposition:attachment;filename=ReporteOperaciones.xls");
	header("Pragma:no-cache");
	header("Expires:0");
	echo "\xEF\xBB\xBF";
	echo $out;
        
	if ( !empty($fechaIni) && !empty($fechaFin) ) {
		$array_params = array(
                array('name' => '_fechaIni',     'value' => $fechaIni,   'type' =>'s'),
                array('name' => '_fechaFin',     'value' => $fechaFin,   'type' =>'s'),
                array('name' => '_metodoPago',   'value' => $metodoPago, 'type' =>'i'),
                array('name' => 'p_buscar',      'value' => '',  'type' => 's'),
                array('name' => 'p_start',       'value' => 0,           'type' =>'i'),
                array('name' => 'p_limit',       'value' => 0,           'type' =>'i'),
                array('name' => 'p_tipo',        'value' => 2,           'type' =>'i')
            );
            $MRDB->setSDatabase('pronosticos');
            $MRDB->setSStoredProcedure('sp_select_ventas');
            $MRDB->setParams($array_params);
            $result = $MRDB->execute();

            if ( $result['nCodigo'] ==0){
	    	$c = "<table>";
	    	$c .= "<thead>";
	    	$c .= "<tr><th colspan='13'>MI SUERTE</th></tr>";
	    	$c .= "<tr><th colspan='13'>REPORTE DE OPERACIONES </th></tr>";
	    	$c .= "<tr><th colspan='13'>PERIODO DEL $fechaIni AL $fechaFin</th></tr>";
	    	$c .= "<tr><th colspan='13'>METODO DE PAGO: $textomPago</th></tr>";
	    	$c .= "<tr><th colspan='13'></th></tr>";
	    	$c .= "<tr>";
	    	$c .= "<th>Fecha Contable</th>";
	    	$c .= "<th>Fecha Solicitud</th>";
	    	$c .= "<th>Fecha Confirmacion</th>";
	    	$c .= "<th>Nombre Juego</th>";
	    	$c .= "<th>Metodo de Pago</th>";
	    	$c .= "<th>Id Folio</th>";
	    	$c .= "<th>Id Folio de Venta</th>";
	    	$c .= "<th>Monto Cargo</th>";
	    	$c .= "<th>Monto Redencion</th>";
	    	$c .= "<th>Total</th>";
	    	$c .= "<th>Comision Pronosticos 10%</th>";
	    	$c .= "</tr>";
	    	$c .= "</thead>";
	    	$c .= "<tbody>";
                
                $data = $MRDB->fetchAll();
                for ($i = 0; $i < count($data); $i++){
                    $d .= "<tr>";
                        $d .= "<td>".($data[$i]["dFechaContable"])."</td>";				
                        $d .= "<td>".($data[$i]["dFecSolicitud"])."</td>";				
                        $d .= "<td>".($data[$i]["dFecConfirmacion"])."</td>";				
                        $d .= "<td>".utf8_decode($data[$i]["sGameName"])."</td>";				
                        $d .= "<td>".utf8_decode($data[$i]["metodo_pago"])."</td>";
                        $d .= "<td>".utf8_decode($data[$i]["nIdFolio"])."</td>";
                        $d .= "<td>".utf8_decode($data[$i]["nIdFolioVenta"])."</td>";
                        $d .= "<td>$".number_format($data[$i]["nMontoCargo"],2,'.',',')."</td>";
                        $d .= "<td>$".number_format($data[$i]["nMontoRedencion"],2,'.',',')."</td>";
                        $d .= "<td>$".number_format($data[$i]["nMonto"],2,'.',',')."</td>";
                        $d .= "<td>$".number_format($data[$i]["comision_pronosticos"],2,'.',',')."</td>";
                    $d .= "</tr>";     
                }                    
                $d .= "</tbody>";
                $d .= "</table>";
                echo $c;
                echo utf8_encode($d);

                $MRDB->closeStmt();
                $totalDatos = $MRDB->foundRows();
                $MRDB->closeStmt();
                        
	    }else{
	    	echo "Lo sentimos pero no se encontraron resultados";
	    }		
	}	
?>
