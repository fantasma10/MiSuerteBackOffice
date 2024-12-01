<?php
	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.inc.php");


	//$tipo = (!empty($_POST['tipo_excel'])) ? $_POST['tipo_excel'] : -1;
	$tipo = $_POST['tipo_excel'];
	$proveedor  = (!empty($_POST['id_proveedor_excel'])) ? $_POST['id_proveedor_excel'] : -1;
	$familia		= (!empty($_POST['id_familia_excel'])) ? $_POST['id_familia_excel'] : -1;
	$fecha1   = (!empty($_POST['fecha1_excel'])) ? $_POST['fecha1_excel'] : date("Y-m-d");
	$fecha2		= (!empty($_POST['fecha2_excel'])) ? $_POST['fecha2_excel'] : date("Y-m-d");



		
	if($tipo == 0){//exportar tabla sin detalle
		header("Content-type=application/x-msdownload; charset=UTF-8");
		header("Content-disposition:attachment;filename=OperacionesProveedores.xls");
		header("Content-Encoding: UTF-8");
		header("Pragma:no-cache");
		header("Expires:0");
		echo "\xEF\xBB\xBF";
		echo $out;
	
		if ( !empty($proveedor) && !empty($fecha1) && !empty($fecha2) ) {
			if($proveedor < -1)
		       	$proveedor = "null";
		    if($familia < -1)
		    	$familia = "null";

			$res = $RBD->query("CALL `redefectiva`.`SP_LOAD_REPORTEPROVEEDORES`('$fecha1', '$fecha2', $proveedor, $familia, 0, 0, 0);");
			if($RBD->error() == ''){
				$pagoProveedor=0;
				$d .= "<table>";
				$d .="<tr><th colspan='11'>Reporte Proveedores</th></tr>";
				$d .="<tr><th colspan='11'>De ".$fecha1." a ".$fecha2."</th></tr>";				
				if($res != '' && mysqli_num_rows($res) > 0){
					$d .= "<thead>";
					$d .= "<tr>";
					$d .= "<th>Total</th>";
					$d .= "<th>RFC</th>";
					$d .= "<th>Proveedor</th>";
					$d .= "<th>Importe</th>";
					$d .= "<th>Comision Usuario</th>";
					$d .= "<th>Importe Total</th>";
					$d .= "<th>Com CxP Prov</th>";
					$d .= "<th>Com CxC Prov</th>";
					$d .= "<th>Com CxP Cliente</th>";
					$d .= "<th>Com CxC Cliente</th>";
					$d .= "<th>Margen Utilidad</th>";
					$d .= "<th>Pago a Proveedor</th>";
					$d .= "</tr>";
					$d .= "</thead>";
					$d .= "<tbody>";

					$nMOV=0;
					$nIMPORTE=0;
					$nCOMISION_CLIENTE=0;
					$nIMPORTE_TOTAL =0;
					$nCOMISION_X_PAGAR =0;
					$nCOMISION_X_COBRAR =0;
					$nCOMISION_X_PAGAR_CLI =0;
					$nCOMISION_X_COBRAR_CLI =0;
					$nMARGEN_UTILIDAD =0;
					$nPAGO_PROVEEDOR =0;

					while( list($idProveedor,$MOV, $PRODUCTO, $NOMBRE_PROVEEDOR, $RAZON_SOCIAL, $RFC, $IMPORTE, $COMISION_CLIENTE, $IMPORTE_TOTAL, $COMISION_X_PAGAR, $COMISION_X_COBRAR, $COMISION_X_PAGAR_CLI, $COMISION_X_COBRAR_CLI,$COMISION_CORRESPONSAL, $MARGEN_UTILIDAD, $PAGO_PROVEEDOR) = mysqli_fetch_array($res)){

						$d .= "<tr>";
						$d .= "<td>".$MOV."</td>";
						$d .= "<td>".utf8_decode($RFC)."</td>";
						$d .= "<td>".utf8_decode($RAZON_SOCIAL)."</td>";
						$d .= "<td>$".$IMPORTE."</td>";
						$d .= "<td>$".$COMISION_CLIENTE."</td>";
						$d .= "<td>$".$IMPORTE_TOTAL."</td>";
						$d .= "<td>$".$COMISION_X_PAGAR."</td>";
						$d .= "<td>$".$COMISION_X_COBRAR."</td>";
						$d .= "<td>$".$COMISION_X_PAGAR_CLI."</td>";
						$d .= "<td>$".$COMISION_X_COBRAR_CLI."</td>";
						$d .= "<td>$".$MARGEN_UTILIDAD."</td>";
						$d .= "<td>$".$PAGO_PROVEEDOR."</td>";
						$d .= "</tr>";
						$nMOV = $nMOV + $MOV;
						$nIMPORTE =	$nIMPORTE + $IMPORTE;
						$nCOMISION_CLIENTE = $nCOMISION_CLIENTE + $COMISION_CLIENTE;
						$nIMPORTE_TOTAL  =	$nIMPORTE_TOTAL + $IMPORTE_TOTAL; 
						$nCOMISION_X_PAGAR  = $nCOMISION_X_PAGAR + $COMISION_X_PAGAR; 
						$nCOMISION_X_COBRAR  = $nCOMISION_X_COBRAR  + $COMISION_X_COBRAR;
						$nCOMISION_X_PAGAR_CLI  = $nCOMISION_X_PAGAR_CLI + $COMISION_X_PAGAR_CLI ;
						$nCOMISION_X_COBRAR_CLI  =	$nCOMISION_X_COBRAR_CLI  + $COMISION_X_COBRAR_CLI;
						$nMARGEN_UTILIDAD  = $nMARGEN_UTILIDAD + $MARGEN_UTILIDAD;
						$nPAGO_PROVEEDOR  =	$nPAGO_PROVEEDOR + $PAGO_PROVEEDOR;

					}			
					$d .= "</tbody>";

					$d .= "<tfoot><tr>";
					$d .= "<th>".$nMOV."</th>";
					$d .= "<th></th>";
					$d .= "<th></th>";
					$d .= "<th>$".$nIMPORTE."</th>";
					$d .= "<th>$".$nCOMISION_CLIENTE."</th>";
					$d .= "<th>$".$nIMPORTE_TOTAL."</th>";
					$d .= "<th>$".$nCOMISION_X_PAGAR."</th>";
					$d .= "<th>$".$nCOMISION_X_COBRAR."</th>";
					$d .= "<th>$".$nCOMISION_X_PAGAR_CLI."</th>";
					$d .= "<th>$".$nCOMISION_X_COBRAR_CLI."</th>";
					$d .= "<th>$".$nMARGEN_UTILIDAD."</th>";
					$d .= "<th>$".$nPAGO_PROVEEDOR."</th>";
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
	}else{
		if($tipo == 1){//exportar tabla con detalle
			header("Content-type=application/x-msdownload; charset=UTF-8");
			header("Content-disposition:attachment;filename=OperacionesProveedores.xls");
			header("Pragma:no-cache");
			header("Expires:0");
			echo "\xEF\xBB\xBF";
			echo $out;
	
			if ( !empty($proveedor) && !empty($fecha1) && !empty($fecha2) ) {
				if($proveedor < -1)
			       	$proveedor = "null";
			    if($familia < -1)
			    	$familia = "null";

				$res = $RBD->query("CALL `redefectiva`.`SP_LOAD_REPORTEPROVEEDORES`('$fecha1', '$fecha2', $proveedor, $familia, 0, -1, 2);");
				if($RBD->error() == ''){
					if($res != '' && mysqli_num_rows($res) > 0){
						$d = "<table>";
						$d .="<tr><th colspan='17'>Reporte Detalle Proveedores</th></tr>";
						$d .="<tr><th colspan='17'>De ".$fecha1." a ".$fecha2."</th></tr>";
						$d .= "<thead>";
						$d .= "<tr>";
						$d .= "<th>Id Folio</th>";
						$d .= "<th>Autorizacion</th>";
						$d .= "<th>Referencia</th>";
						$d .= "<th>Producto</th>";
						$d .= "<th>Importe</th>";
						$d .= "<th>Comision Usuario</th>";
						$d .= "<th>Importe Total</th>";
						$d .= "<th>Com CxP Prov</th>";
						$d .= "<th>Com CxC Prov</th>";
						$d .= "<th>Com CxP Cliente</th>";
						$d .= "<th>Com CxC Cliente</th>";
						$d .= "<th>Margen Utilidad</th>";
						$d .= "<th>Pago a Proveedor</th>";
						$d .= "<th>Fecha</th>";
						$d .= "<th>Cta. Contable</th>";
						$d .= "<th>Corresponsal</th>";
						$d .= "<th>Proveedor</th>";
						$d .= "</tr>";
						$d .= "</thead>";
						$d .= "<tbody>";
						while( list($idsOperacion, $AUTORIZACION, $REFERENCIA, $PRODUCTO, $IMPORTE, $COMISION_CLIENTE, $IMPORTE_TOTAL, $COMISION_X_PAGAR, $COMISION_X_COBRAR,$COMISION_X_PAGAR_CLI,$COMISION_X_COBRAR_CLI, $COMISION_CORRESPONSAL, $MARGEN_UTILIDAD, $PAGO_PROVEEDOR, $FECHA, $NOMCORR, $CUENTACONTABLE,$NOMBRE_PROVEEDOR) = mysqli_fetch_array($res)){

							$d .= "<tr>";
							$d .= "<td>".$idsOperacion."</td>";
							$d .= "<td>'".$AUTORIZACION."</td>";
							$d .= "<td>'".$REFERENCIA."</td>";
							$d .= "<td>".$PRODUCTO."</td>";
							$d .= "<td>$".$IMPORTE."</td>";
							$d .= "<td>$".$COMISION_CLIENTE."</td>";
							$d .= "<td>$".$IMPORTE_TOTAL."</td>";
							$d .= "<td>$".$COMISION_X_PAGAR."</td>";
							$d .= "<td>$".$COMISION_X_COBRAR."</td>";
							$d .= "<td>$".$COMISION_X_PAGAR_CLI."</td>";
							$d .= "<td>$".$COMISION_X_COBRAR_CLI."</td>";
							$d .= "<td>$".$MARGEN_UTILIDAD."</td>";
							$d .= "<td>$".$PAGO_PROVEEDOR."</td>";
							$d .= "<td>".$FECHA."</td>";							
							$d .= "<td>".$CUENTACONTABLE."</td>";
							$d .= "<td>".$NOMCORR."</td>";
							$d .= "<td>".$NOMBRE_PROVEEDOR."</td>";
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

		if($tipo == 2){//exportar tabla con detalle ???j
			header("Content-type=application/x-msdownload; charset=UTF-8");
			header("Content-disposition:attachment;filename=OperacionesProveedores.xls");
			header("Pragma:no-cache");
			header("Expires:0");
			echo "\xEF\xBB\xBF";
			echo $out;
	
			if ( !empty($proveedor) && !empty($fecha1) && !empty($fecha2) ) {
				if($proveedor < -1)
			       	$proveedor = "null";
			    if($familia < -1)
			    	$familia = "null";


				$res = $RBD->query("CALL `redefectiva`.`sp_reporte_prov_detalle`('$fecha1', '$fecha2', $proveedor, $familia, 0, 0,2);");
				if($RBD->error() == ''){
					if($res != '' && mysqli_num_rows($res) > 0){
						$d = "<table>";
						$d .= "<thead>";
						$d .= "<tr>";
						$d .= "<th>REFERENCIA</th>";
						$d .= "<th>FECHA</th>";
						$d .= "<th>HORA</th>";
						$d .= "<th>IMPORTE</th>";
						$d .= "<th>COMISION</th>";
						$d .= "<th>IVA</th>";
						$d .= "<th>ID COMERCIO</th>";
						$d .= "<th>COMERCIO</th>";
						$d .= "<th>NO AUTORIZACION</th>";
						$d .= "<th>F.LIQUID</th>";
						$d .= "</tr>";
						$d .= "</thead>";
						$d .= "<tbody>";
						while( list($IDSOPERACION, $REFERENCIA, $FECHA_OP, $HORA_OP, $IMPORTE_UFINAL_VALOR, $COMISION_ENTIDAD_VALOR, $IVA_COMISION, $ID_COMERCIO, $NOMBRE_COMERCIO, $NO_AUTORIZACION, $LIQUIDACION) = mysqli_fetch_array($res)){

							$d .= "<tr>";
							$d .= "<td>".$REFERENCIA."</td>";
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

		if($tipo == 3){// exportat tabla por producto
			header("Content-type=application/x-msdownload; charset=UTF-8");
			header("Content-disposition:attachment;filename=OperacionesProvedores_productos.xls");
			header("Content-Encoding: UTF-8");
			header("Pragma:no-cache");
			header("Expires:0");
			echo "\xEF\xBB\xBF";
			echo $out;
		
			if ( !empty($proveedor) && !empty($fecha1) && !empty($fecha2) ) {
				if($proveedor < -1)
			       	$proveedor = "null";
			    if($familia < -1)
			    	$familia = "null";

			    
				$res = $RBD->query("CALL `redefectiva`.`SP_LOAD_REPORTEPROVEEDORES`('$fecha1', '$fecha2', $proveedor, $familia, 0, 0, 4);");
				if($RBD->error() == ''){
					$d .= "<table>";
					$d .="<tr><th colspan='12'>Reporte por producto</th></tr>";
					$d .="<tr><th colspan='12'>De ".$fecha1." a ".$fecha2."</th></tr>";
					if($res != '' && mysqli_num_rows($res) > 0){						
						$d .= "<thead>";
						$d .= "<tr>";
						$d .= "<th>Total</th>";
						$d .= "<th>Producto</th>";
						$d .= "<th>Retenci&oacute;n</th>";
						$d .= "<th>Importe</th>";
						$d .= "<th>Comision Usuario</th>";
						$d .= "<th>Importe Total</th>";
						$d .= "<th>Com CxP Prov</th>";
						$d .= "<th>Com CxC Prov</th>";
						$d .= "<th>Com CxP Cliente</th>";
						$d .= "<th>Com CxC Cliente</th>";
						$d .= "<th>Margen Utilidad</th>";
						$d .= "<th>Pago a Proveedor</th>";
						$d .= "</tr>";
						$d .= "</thead>";
						$d .= "<tbody>";

						$nMOV=0;
						$nIMPORTE=0;
						$nCOMISION_CLIENTE=0;
						$nIMPORTE_TOTAL =0;
						$nCOMISION_X_PAGAR =0;
						$nCOMISION_X_COBRAR =0;
						$nCOMISION_X_PAGAR_CLI =0;
						$nCOMISION_X_COBRAR_CLI =0;
						$nMARGEN_UTILIDAD =0;
						$nPAGO_PROVEEDOR =0;

						while( list($MOV, $NOMBRE_PRODUCTO, $IMPORTE, $COMISION_CLIENTE, $IMPORTE_TOTAL, $COMISION_X_PAGAR, $COMISION_X_COBRAR, $COMISION_X_PAGAR_CLI, $COMISION_X_COBRAR_CLI, $COMISION_CORRESPONSAL, $MARGEN_UTILIDAD, $PAGO_PROVEEDOR,$RETENCION) = mysqli_fetch_array($res)){
							$sRetencion='';
							if($RETENCION==1){
								$sRetencion = 'Sin retencion';
							}else{
								$sRetencion = 'Con retencion';
							}

							$d .= "<tr>";
							$d .= "<td>".$MOV."</td>";
							$d .= "<td>".$NOMBRE_PRODUCTO."</td>";
							$d .= "<td>".$sRetencion ."</td>";
							$d .= "<td>$".$IMPORTE."</td>";
							$d .= "<td>$".$COMISION_CLIENTE."</td>";
							$d .= "<td>$".$IMPORTE_TOTAL."</td>";
							$d .= "<td>$".$COMISION_X_PAGAR."</td>";
							$d .= "<td>$".$COMISION_X_COBRAR."</td>";
							$d .= "<td>$".$COMISION_X_PAGAR_CLI."</td>";
							$d .= "<td>$".$COMISION_X_COBRAR_CLI."</td>";
							$d .= "<td>$".$MARGEN_UTILIDAD."</td>";
							$d .= "<td>$".$PAGO_PROVEEDOR."</td>";
							$d .= "</tr>";	

							$nMOV = $nMOV + $MOV;
							$nIMPORTE =	$nIMPORTE + $IMPORTE;
							$nCOMISION_CLIENTE = $nCOMISION_CLIENTE + $COMISION_CLIENTE;
							$nIMPORTE_TOTAL  =	$nIMPORTE_TOTAL + $IMPORTE_TOTAL; 
							$nCOMISION_X_PAGAR  = $nCOMISION_X_PAGAR + $COMISION_X_PAGAR; 
							$nCOMISION_X_COBRAR  = $nCOMISION_X_COBRAR  + $COMISION_X_COBRAR;
							$nCOMISION_X_PAGAR_CLI  = $nCOMISION_X_PAGAR_CLI + $COMISION_X_PAGAR_CLI ;
							$nCOMISION_X_COBRAR_CLI  =	$nCOMISION_X_COBRAR_CLI  + $COMISION_X_COBRAR_CLI;
							$nMARGEN_UTILIDAD  = $nMARGEN_UTILIDAD + $MARGEN_UTILIDAD;
							$nPAGO_PROVEEDOR  =	$nPAGO_PROVEEDOR + $PAGO_PROVEEDOR;						
						}			
						$d .= "</tbody>";

							$d .= "<tfoot><tr>";
							$d .= "<th>".$nMOV."</th>";
							$d .= "<th></th>";
							$d .= "<th></th>";
							$d .= "<th>$".$nIMPORTE."</th>";
							$d .= "<th>$".$nCOMISION_CLIENTE."</th>";
							$d .= "<th>$".$nIMPORTE_TOTAL."</th>";
							$d .= "<th>$".$nCOMISION_X_PAGAR."</th>";
							$d .= "<th>$".$nCOMISION_X_COBRAR."</th>";
							$d .= "<th>$".$nCOMISION_X_PAGAR_CLI."</th>";
							$d .= "<th>$".$nCOMISION_X_COBRAR_CLI."</th>";
							$d .= "<th>$".$nMARGEN_UTILIDAD."</th>";
							$d .= "<th>$".$nPAGO_PROVEEDOR."</th>";
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
	}

?>
