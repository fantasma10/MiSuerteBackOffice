<?php
	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.inc.php");



	$p_sRFC = $_POST["rfc_excel"];
    if(empty($p_sRFC)){
    	$p_sRFC="empty";
    }

	$p_nIdEstatus = $_POST["estatus_excel"];
	if($p_nIdEstatus==-1){
		$p_nIdEstatus = "empty";
	}
	$p_dFechaInicio = $_POST["fecha1_excel"];
	$p_dFechaFin = $_POST["fecha2_excel"];

	
		header("Content-type=application/x-msdownload; charset=UTF-8");
		header("Content-disposition:attachment;filename=OrdenesPago.xls");
		header("Pragma:no-cache");
		header("Expires:0");
		echo "\xEF\xBB\xBF";
		echo $out;
		if ( !empty($p_dFechaInicio) && !empty($p_dFechaFin) ) {
			$res = $RBD->query("CALL `redefectiva`.`sp_select_ordenes_pagos`('$p_nIdEstatus','$p_dFechaInicio', '$p_dFechaFin', '$p_sRFC',0,0,0,2);");

			if($RBD->error() == ''){
				if($res != '' && mysqli_num_rows($res) > 0){
						$c = "<table>";
						$c .= "<thead>";
						$c .= "<tr>";
						$c .= "<th>Id</th>";
						$c .= "<th>Fecha Orden Pago</th>";
						$c .= "<th>Fecha Pago</th>";
						$c .= "<th>Tipo Pago</th>";
						$c .= "<th>Origen</th>";
						$c .= "<th>Destino</th>";
						$c .= "<th>Importe</th>";
						$c .= "<th>Importe Transferencia</th>";
						$c .= "<th>Importe pago</th>";
						$c .= "<th>Beneficiario</th>";
						$c .= "<th>Correo</th>";
						$c .= "</tr>";
						$c .= "</thead>";
						$c .= "<tbody>";
					while( list($nIdOrdenPago,$dFechaRegistro,$dFechaPago,$nIdTipoPago,$sCuentaOrigen,$sCuentaBeneficiario,$importe,$importe_transferencia,$nTotal,$sBeneficiario,$sCorreoDestino) = mysqli_fetch_array($res)){
						$d .= "<tr>";
						$d .= "<td>".$nIdOrdenPago."</td>";
						$d .= "<td>".$dFechaRegistro."</td>";
						$d .= "<td>".$dFechaPago."</td>";
						$d .= "<td>".$nIdTipoPago."</td>";
						$d .= "<td>".$sCuentaOrigen."</td>";
						$d .= "<td>'".$sCuentaBeneficiario."</td>";
						$d .= "<td>".$importe."</td>";
						$d .= "<td>".$importe_transferencia."</td>";
						$d .= "<td>".$nTotal."</td>";
						$d .= "<td>".$sBeneficiario."</td>";
						$d .= "<td>".$sCorreoDestino."</td>";
						$d .= "</tr>";
					}			
					$d .= "</tbody>";
					$d .= "</table>";
					echo $c;
					echo utf8_encode($d);		
				}else{
					echo "Lo sentimos pero no se encontraron resultados";
				}
			}else{
				echo "Error al realizar la consulta: ".$RBD->error();
			}
		}	
?>
