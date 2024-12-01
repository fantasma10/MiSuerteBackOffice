<?php
	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.inc.php");


	$tipo = $_POST['tipo_exceldetallesemanal'];
	$proveedor  = (!empty($_POST['id_proveedor_exceldetallesemanal'])) ? $_POST['id_proveedor_exceldetallesemanal'] : -1;
	$familia		= (!empty($_POST['id_familia_exceldetallesemanal'])) ? $_POST['id_familia_exceldetallesemanal'] : -1;
	$fecha1   = (!empty($_POST['fecha1_exceldetallesemanal'])) ? $_POST['fecha1_exceldetallesemanal'] : date("Y-m-d");
	$fecha2		= (!empty($_POST['fecha2_exceldetallesemanal'])) ? $_POST['fecha2_exceldetallesemanal'] : date("Y-m-d");

	if ($tipo==5) {
			header("Content-type=application/x-msdownload; charset=UTF-8");
			header("Content-disposition:attachment;filename=DetalleProveedorSemanal.xls");
			header("Pragma:no-cache");
			header("Expires:0");
			echo "\xEF\xBB\xBF";
			echo $out;

			if ( !empty($proveedor) && !empty($fecha1) && !empty($fecha2) ) {
				if($proveedor < -1)
			       	$proveedor = "null";
			    if($familia < -1)
			    	$familia = "null";


				$res = $RBD->query("CALL `redefectiva`.`sp_reporte_prov_detalle`('$fecha1', '$fecha2', $proveedor, $familia, 0, -1, 2);");

				if($RBD->error() == ''){
					if($res != '' && mysqli_num_rows($res) > 0){


						$d = "<table>";
						$d .= "<thead>";
						$d .= "<tr>";
						$d .= "<th>DIA COBRANZA</th>";
						$d .= "<th>RECIBOS</th>";
						$d .= "<th>IMPORTE COBRANZA</th>";
						$d .= "<th>COMISION</th>";						
						$d .= "<th>IMPORTE LIQUIDACION</th>";
						$d .= "<th>FECHA LIQUIDACION</th>";
						$d .= "</tr>";
						$d .= "</thead>";
						$d .= "<tbody>";

				while( list($FECHA, $TOTAL, $IMPORTE_COBRANZA, $DIA_SIGUIENTE, $COMISION, $IMPORTE_LIQUIDACION) = mysqli_fetch_array($res)){

								$d .= "<tr>";
								$d .= "<td>".$FECHA."</td>";
								$d .= "<td>".$TOTAL."</td>";
								$d .= "<td>$".$IMPORTE_COBRANZA."</td>";
								$d .= "<td>$".$COMISION."</td>";
								$d .= "<td>$".$IMPORTE_LIQUIDACION."</td>";
								$d .= "<td>".$DIA_SIGUIENTE."</td>";
								$d .= "</tr>";
						}			
						$d .= "</tbody>";
						$d .= "</table>";
						echo utf8_encode($d);		
					}else{
						echo "Lo sentimos pero no se encontraron resultados";
					}
				}else{
					echo "Error al realizar la consulta: ".$RBD->error();
				}
			}
		}

?>
