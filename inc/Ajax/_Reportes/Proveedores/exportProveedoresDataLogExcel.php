<?php
	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.inc.php");

	$tipo = $_POST['tipo_excel'];
	$proveedor  = (!empty($_POST['id_proveedor_excel'])) ? $_POST['id_proveedor_excel'] : -1;
	//$familia		= (!empty($_POST['id_familia_excel'])) ? $_POST['id_familia_excel'] : -1;
	$fecha1   = (!empty($_POST['fecha1_excel'])) ? $_POST['fecha1_excel'] : date("Y-m-d");
	$fecha2		= (!empty($_POST['fecha2_excel'])) ? $_POST['fecha2_excel'] : date("Y-m-d");
		
	if($tipo == 0){//exportar tabla sin detalle
		header("Content-type=application/x-msdownload; charset=UTF-8");
		header("Content-disposition:attachment;filename=OperacionesProveedoresDataLog.xls");
		header("Pragma:no-cache");
		header("Expires:0");
		echo "\xEF\xBB\xBF";
		echo $out;
	
		if ( !empty($proveedor) && !empty($fecha1) && !empty($fecha2) ) {
			if($proveedor < -1)
		       	$proveedor = 0;
		    if($familia < -1)
		    	$familia = "null";

			$sql = $RBD->query("CALL `nautilus`.`sp_select_proveedor_conector`($proveedor);");
			if($RBD->error() == ''){
				if($sql != '' && mysqli_num_rows($sql) > 0){
					$d = "<table>";
					$d .= "<thead>";
					$d .= "<tr>";
					$d .= "<th>Total</th>";
					$d .= "<th>IdProveedor</th>";
					$d .= "<th>Nombre Proveedor</th>";
					$d .= "<th>Importe</th>";
					$d .= "</tr>";
					$d .= "</thead>";
					$d .= "<tbody>";

					$sumTotalOperacion = 0;
					$sumImporteTotal = 0;					
					while ($row = mysqli_fetch_assoc($sql)) {
						$idProveedor = $row["idProveedor"];
						$nomProveedor = $row["NomProveedor"];
						if(strlen($row["idConector"])<3)
							$num_conector = str_pad($row["idConector"],3,"0",STR_PAD_LEFT);
						else
							$num_conector = $row["idConector"];

						$array_params = array(
							array('name' => 'p_num_conector', 'value' => $num_conector, 'type' =>'s'),
							array('name' => 'p_fecha1', 'value' => $fecha1, 'type' =>'s'),
							array('name' => 'p_fecha2', 'value' => $fecha2, 'type' =>'s')
						);
						$oRDLdb->setSDatabase('data_log');
	    				$oRDLdb->setSStoredProcedure('sp_select_reporte_conector');
	    				$oRDLdb->setParams($array_params);
	    				$result = $oRDLdb->execute();	
	    				if ( $result['nCodigo'] ==0){
					    	$data2 = $oRDLdb->fetchAll();	
					    	$oRDLdb->closeStmt();				
							for($j=0;$j<count($data2);$j++){	
								if($data2[$j]["totalOperaciones"]>0){							
									$totalOperacion = $data2[$j]['totalOperaciones'];
									$importeTotal = $data2[$j]["sumaImporte"];
									$d .= "<tr>";
									$d .= "<td>".$totalOperacion."</td>";
									$d .= "<td>".$idProveedor."</td>";
									$d .= "<td>".utf8_encode($nomProveedor)."</td>";
									$d .= "<td>$".$importeTotal."</td>";
									$d .= "</tr>";
									$sumTotalOperacion = $sumTotalOperacion + $totalOperacion;
									$sumImporteTotal = $sumImporteTotal + $importeTotal;
									$index++;
								}																
							}
					
					    }
					}
					$d .= "</tbody>";
					
					$d .= "<tfoot><tr>";
					$d .= "<th>".$sumTotalOperacion."</th>";
					$d .= "<th></th>";
					$d .= "<th></th>";
					$d .= "<th>$".$sumImporteTotal."</th>";
					$d .= "</tr></tfoot>";			

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
