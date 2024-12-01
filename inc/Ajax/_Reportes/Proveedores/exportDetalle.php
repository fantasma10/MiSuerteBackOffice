<?php
	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.inc.php");


	$tipo = $_POST['tipo_exceldetalle'];
	$proveedor  = (!empty($_POST['id_proveedor_exceldetalle'])) ? $_POST['id_proveedor_exceldetalle'] : -1;
	$familia		= (!empty($_POST['id_familia_exceldetalle'])) ? $_POST['id_familia_exceldetalle'] : -1;
	$fecha1   = (!empty($_POST['fecha1_exceldetalle'])) ? $_POST['fecha1_exceldetalle'] : date("Y-m-d");
	$fecha2		= (!empty($_POST['fecha2_exceldetalle'])) ? $_POST['fecha2_exceldetalle'] : date("Y-m-d");

	if ($tipo==4) {
			header("Content-type=application/x-msdownload; charset=UTF-8");
			header("Content-disposition:attachment;filename=DetalleProveedor.xls");
			header("Pragma:no-cache");
			header("Expires:0");
			echo "\xEF\xBB\xBF";
			echo $out;

			if ( !empty($proveedor) && !empty($fecha1) && !empty($fecha2) ) {
				if($proveedor < -1)
			       	$proveedor = "null";
			    if($familia < -1)
			    	$familia = "null";


				$res = $RBD->query("CALL `redefectiva`.`sp_reporte_prov_detalle`('$fecha1', '$fecha2', $proveedor, $familia, 0, 10000, 1);");

				$contadorNombreProveedor=1;
				if($RBD->error() == ''){
					if($res != '' && mysqli_num_rows($res) > 0){
						while( list($idsOperacion, $REFERENCIA, $FECHA_OP, $HORA_OP, $IMPORTE_UFINAL_VALOR, $COMISION_ENTIDAD_VALOR, $IVA_COMISION, $ID_COMERCIO, $NOMBRE_COMERCIO, $NO_AUTORIZACION, $LIQUIDACION,$NOMBREPROVEEDOR) = mysqli_fetch_array($res)){


							if($contadorNombreProveedor==1){
								$d = "<table>";
								$d .= "<thead>";
								$d .= "<tr>";
								$d .= "<th>".$NOMBREPROVEEDOR."</th>";
								$d .= "<th></th>";
								$d .= "<th></th>";
								$d .= "<th></th>";
								$d .= "<th></th>";
								$d .= "<th></th>";
								$d .= "<th></th>";
								$d .= "<th></th>";
								$d .= "<th></th>";
								$d .= "<th></th>";
								$d .= "<th></th>";
								$d .= "</thead>";

								$d .= "<tbody>";
								$d .="<tr>";
			                    $d .= "<th>IDS OPERACION</th>";
			                    $d .= "<th>REFERENCIA</th>";
			                    $d .= "<th>FECHA</th>";
			                    $d .= "<th>HORA</th>";
			                    $d .= "<th>IMPORTE</th>";
			                    $d .= "<th>COMISION</th>";
			                    $d .= "<th>IVA</th>";
			                    $d .= "<th>ID COMERCIO</th>";
			                    $d .= "<th>COMERCIO</th>";
			                    $d .= "<th>NO AUTORIZACION</th>";
			                    $d .= "<th>LIQUIDACION</th>";
								$d .= "</tr>";
								

								$d .= "<tr>";
								$d .= "<td>".$idsOperacion."</td>";
								$d .= "<td>'".$REFERENCIA."</td>";
								$d .= "<td>".$FECHA_OP."</td>";
								$d .= "<td>".$HORA_OP."</td>";
								$d .= "<td>$".$IMPORTE_UFINAL_VALOR."</td>";
								$d .= "<td>$".$COMISION_ENTIDAD_VALOR."</td>";
								$d .= "<td>$".$IVA_COMISION."</td>";
								$d .= "<td>".$ID_COMERCIO."</td>";
								$d .= "<td>".$NOMBRE_COMERCIO."</td>";
								$d .= "<td>".$NO_AUTORIZACION."</td>";
								$d .= "<td>".$LIQUIDACION."</td>";
								$d .= "</tr>";

							}else{
								$d .= "<tr>";
								$d .= "<td>".$idsOperacion."</td>";
								$d .= "<td>'".$REFERENCIA."</td>";
								$d .= "<td>".$FECHA_OP."</td>";
								$d .= "<td>".$HORA_OP."</td>";
								$d .= "<td>$".$IMPORTE_UFINAL_VALOR."</td>";
								$d .= "<td>$".$COMISION_ENTIDAD_VALOR."</td>";
								$d .= "<td>$".$IVA_COMISION."</td>";
								$d .= "<td>".$ID_COMERCIO."</td>";
								$d .= "<td>".$NOMBRE_COMERCIO."</td>";
								$d .= "<td>".$NO_AUTORIZACION."</td>";
								$d .= "<td>".$LIQUIDACION."</td>";
								$d .= "</tr>";
							}
							$contadorNombreProveedor++;

							
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
