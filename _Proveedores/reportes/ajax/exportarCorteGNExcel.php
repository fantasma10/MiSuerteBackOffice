<?php
	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.inc.php");

	$GASNATURAL=27;
	$proveedor 	= (!empty($_POST['id_proveedor_excel'])) ? $_POST['id_proveedor_excel'] : 0;
	$fecha1   	= (!empty($_POST['fecha1_excel'])) ? $_POST['fecha1_excel'] : date("Y-m-d");
	$fecha2		= (!empty($_POST['fecha2_excel'])) ? $_POST['fecha2_excel'] : date("Y-m-d");
	$fechaTipo		= (!empty($_POST['tipo'])) ? $_POST['tipo']: $_POST['tipo'];
	$fileNameChange = $fechaTipo == 1 ? "FechaCorte" : "FechaPago";
	
		header("Content-type=application/x-msdownload; charset=UTF-8");
		header("Content-disposition:attachment;filename=CorteProveedorGN_$fileNameChange.xls");
		header("Pragma:no-cache");
		header("Expires:0");
		echo "\xEF\xBB\xBF";
		echo $out;

		if ( !empty($fecha1) && !empty($fecha2) ) {
			$res = $RBD->query("CALL `redefectiva`.`sp_select_corte_proveedor_GN`($proveedor,'$fecha1', '$fecha2', 0, -1,'',$fechaTipo);");

			if($RBD->error() == ''){
				if($res != '' && mysqli_num_rows($res) > 0){
					$c = "<table>";
					$c .= "<thead>";
					$c .= "<tr><th colspan='10'>REPORTE PARA PAGO GAS NATURAL NATURGY</th></tr>";
			    	$c .= "<tr><th colspan='10'>$fecha1 AL $fecha2</th></tr>";
			    	$c .= "<tr><th></th></tr>";
					$c .= "<tr>";
					$c .= "<th>Id Proveedor</th>";
					$c .= "<th>Proveedor</th>";
					$c .= "<th>Fecha Corte</th>";
					$c .= "<th>Fecha Pago</th>";
					$c .= "<th>Tipo</th>";
					$c .= "<th>Zona</th>";
					$c .= "<th>Nombre Zona</th>";
					$c .= "<th>Clabe</th>";
					$c .= "<th>Total Operaciones</th>";
					$c .= "<th>Total Monto</th>";
					$c .= "<th>Total Comisión</th>";
					$c .= "<th>Total Pago</th>";
					$c .= "</tr>";
					$c .= "</thead>";
					$c .= "<tbody>";
					
					$totalOpe = 0;
			    	$totalMonto = 0;
			    	$totalComision = 0;	    	
			    	$total = 0;

					while( list($nIdProveedor, $nZona, $sNombreZona, $nIdProducto, $sNombreProducto, $nombreProveedor, $sClabe, $nTotalOperaciones, $nTotalMonto, $nTotalComision, $nTotalPago, $dFecha, $dFechaPago) = mysqli_fetch_array($res)){
						$nomProducto ="";
						if($nIdProducto>0 && $nIdProveedor==$GASNATURAL){
	                		$nomProducto =  $sNombreProducto;
	                	}else{
	                		if($nIdProducto==0 && $nIdProveedor==$GASNATURAL){
	                			$nomProducto =  "Online";
	                		}else{
	                			$nomProducto =  "";
	                		}                	
	                	}

						$d .= "<tr>";
						$d .= "<td>".$nIdProveedor."</td>";
						$d .= "<td>".$nombreProveedor."</td>";
						$fechaTipo == 1 ? $d .= "<td>".$dFecha."</td>" : $d .= "<td></td>";
						$d .= "<td>".$dFechaPago."</td>";
						$d .= "<td>".$nomProducto."</td>";
						$d .= "<td>".$nZona."</td>";
						$d .= "<td>".$sNombreZona."</td>";
						$d .= "<td>'".$sClabe."</td>";
						$d .= "<td>".$nTotalOperaciones."</td>";
						$d .= "<td>$".$nTotalMonto."</td>";
						$d .= "<td>$".$nTotalComision."</td>";
						$d .= "<td>$".$nTotalPago."</td>";
						$d .= "</tr>";
						$totalOpe = $totalOpe + $nTotalOperaciones;
						$totalMonto = $totalMonto + $nTotalMonto;
						$totalComision = $totalComision + $nTotalComision;
						$total = $total + $nTotalPago;
					}
					$d .= "<tr><th colspan='8' align='right'>TOTAL</th><th align='right'>".$totalOpe."</th><th align='right'>$".$totalMonto."</th><th align='right'>$".$totalComision."</th><th align='right'>$".$total."</th></tr>";		
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
