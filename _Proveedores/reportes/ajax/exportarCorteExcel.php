<?php
	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.inc.php");

	$proveedor 	= (!empty($_POST['id_proveedor_excel'])) ? $_POST['id_proveedor_excel'] : 0;
	$fecha1   	= (!empty($_POST['fecha1_excel'])) ? $_POST['fecha1_excel'] : date("Y-m-d");
	$fecha2		= (!empty($_POST['fecha2_excel'])) ? $_POST['fecha2_excel'] : date("Y-m-d");
	$fechaTipo 	= (!empty($_POST['tipo'])) ? $_POST['tipo'] : 0;
	$fileNameChange = $fechaTipo == 1 ? "FechaCorte" : "FechaPago";
	
		header("Content-type=application/x-msdownload; charset=UTF-8");
		header("Content-disposition:attachment;filename=ReporteCorte_$fileNameChange.xls");
		header("Pragma:no-cache");
		header("Expires:0");
		echo "\xEF\xBB\xBF";
		echo $out;

		if ( !empty($fecha1) && !empty($fecha2) ) {
			$res = $RBD->query("CALL `redefectiva`.`sp_select_corte_proveedor`($proveedor,'$fecha1', '$fecha2', 0, -1,'',0,$fechaTipo);");

			if($RBD->error() == ''){
				$total_pago = 0;
				$total_comision_cxp = 0;
				$total_comision_cxc = 0;
				$total_comision_trans = 0;
				$total_monto = 0;
				$total_operaciones = 0;
				$c = "<table>
				<tr><th colspan='10'>CORTE PROVEEDOR</th></tr>
				<tr><td colspan='10'><center><b>De: </b> ".$fecha1."<b> Hasta: <b>".$fecha2." </center></td></tr>
				</table>";
				if($res != '' && mysqli_num_rows($res) > 0){
					$c .= "<table>";
					$c .= "<thead>";
					$c .= "<tr>";
					$c .= "<th>Id</th>";
					$c .= "<th>Proveedor</th>";
					$c .= "<th>Fecha Corte</th>";
					$c .= "<th>Fecha Pago</th>";
					$c .= "<th>Total Operaciones</th>";
					$c .= "<th>Total Monto</th>";
					$c .= "<th>Comisión CxC</th>";
					$c .= "<th>Comisión CxP</th>";
					$c .= "<th>Comisión Transferencia</th>";
					$c .= "<th>Total Pago</th>";
					$c .= "</tr>";
					$c .= "</thead>";
					$c .= "<tbody>";
					
					while( list($nIdCorte,$nZona,$sNombreZona,$nIdEstatus,$nIdProveedor,$nombreProveedor,$razonSocial,$nTotalOperaciones,$nTotalMonto,$nTotalComision,$nTotalPago,$dFecha,$dFechaPago,$nComisionCxP,$nEnviaReporte,$nImporteTransferencia) = mysqli_fetch_array($res)){
						$d .= "<tr>";
						$d .= "<td>".$nIdProveedor."</td>";
						$d .= "<td>".$razonSocial."</td>";
						$fechaTipo == 1 ? $d .= "<td>".$dFecha."</td>" : $d .= "<td></td>";
						$d .= "<td>".$dFechaPago."</td>";
						$d .= "<td>".$nTotalOperaciones."</td>";
						$d .= "<td>$".$nTotalMonto."</td>";
						$d .= "<td>$".$nTotalComision."</td>";
						$d .= "<td>$".$nComisionCxP."</td>";
						$d .= "<td>$".$nImporteTransferencia."</td>";
						$d .= "<td>$".$nTotalPago."</td>";
						$d .= "</tr>";

						$total_operaciones 	+= $nTotalOperaciones;
						$total_monto 		+= $nTotalMonto;
						$total_comision_cxc += $nTotalComision;
						$total_comision_cxp += $nComisionCxP;
						$total_comision_trans += $nImporteTransferencia;
						$total_pago 		+= $nTotalPago;
					}
					$d .= "<tr>";
					$d .= "<th colspan='4' align='center'>TOTAL</th>";
					$d .= "<th align='right'>". $total_operaciones ."</th>";
					$d .= "<th align='right'>$". number_format($total_monto, 2)."</th>";
					$d .= "<th align='right'>$". number_format($total_comision_cxc, 2) ."</th>";
					$d .= "<th align='right'>$". number_format($total_comision_cxp, 2) ."</th>"; 
					$d .= "<th align='right'>$". number_format($total_comision_trans, 2) ."</th>"; 
					$d .= "<th align='right'>$". number_format($total_pago, 2) ."</th>";
					$d .= "</tr>";

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
