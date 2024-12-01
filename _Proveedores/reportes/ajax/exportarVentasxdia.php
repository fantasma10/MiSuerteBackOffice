<?php
	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.inc.php");
	
	$p_dFechaInicio = $_POST["fecha1_excel"];
	$p_dFechaFin = $_POST["fecha2_excel"];
	$familia_select_excel = $_POST["familia_select_excel"];
	$cadena = (!empty($_POST['cadena_excel'])) ? $_POST['cadena_excel'] : -1;
	$subcadena = (!empty($_POST['subcadena_excel'])) ? $_POST['subcadena_excel'] : -1; 
	$corresponsal = (!empty($_POST['corresponsal_excel'])) ? $_POST['corresponsal_excel'] : -1;
	$cadena_txt = (!empty($_POST['cadena_txt'])) ? $_POST['cadena_txt'] : "";
	$str ="";

	if($familia_select_excel==-1){
		$familia_select_excel=0;
	}

	if($cadena==-1){
		$cadena = 'NULL';
		$subcadena = 'NULL';
		$corresponsal = 'NULL';
	}
	if($subcadena==-1){
		$subcadena = 'NULL';
	}
	if($corresponsal==-1){
		$corresponsal = 'NULL';
	}
	 
		header("Content-type=application/x-msdownload; charset=UTF-8");
		header("Content-disposition:attachment;filename=VentasxDia.xls");
		header("Pragma:no-cache");
		header("Expires:0");
		echo "\xEF\xBB\xBF";
		echo $out;

		if ( !empty($p_dFechaInicio) && !empty($p_dFechaFin) ) {
		$res = $RBD->query("CALL redefectiva.sp_select_info_corte_ventas('$p_dFechaInicio','$p_dFechaFin',$familia_select_excel,0,-1,'',$cadena,$subcadena,$corresponsal);");
		
			if($RBD->error() == ''){
				if($res != '' && mysqli_num_rows($res) > 0){
						$c = "<table>";
						$c .= "<thead>";
						$c .="<tr><th colspan='8'>REPORTE VENTAS POR DIA ".$cadena_txt."</th></tr>";
						$c .="<tr><td colspan='8'><center><b>De: </b> ".$p_dFechaInicio."<b> Hasta: </b>".$p_dFechaFin." </center></td></tr>";
						$c .= "<tr>";
						$c .= "<th>Mes</th>";
						$c .= "<th>FecAltaOperacion</th>";
						$c .= "<th>IdCadena</th>";
						$c .= "<th>NombreCadena</th>";
						$c .= "<th>IdSubCadena</th>";
						$c .= "<th>NombreSubCadena</th>";
						$c .= "<th>IdCorresponsal</th>";
						$c .= "<th>NombreCorresponsal</th>";
						$c .= "<th>RFCCliente</th>";
						$c .= "<th>IdProveedor</th>";
						$c .= "<th>NombreProveedor</th>";
						$c .= "<th>RFCProveedor</th>";
						$c .= "<th>IdFamilia</th>";
						$c .= "<th>DescFamilia</th>";
						$c .= "<th>IdEmisor</th>";
						$c .= "<th>DescEmisor</th>";
						$c .= "<th>IdProducto</th>";
						$c .= "<th>DescProducto</th>";
						$c .= "<th>NumCuenta</th>";
						$c .= "<th>CtaContable</th>";
						$c .= "<th>Ventas</th>";
						$c .= "<th>Importe</th>";
						$c .= "<th>Retiros</th>";
						$c .= "<th>CxP Cliente</th>";
						$c .= "<th>CxC Cliente</th>";
						$c .= "<th>ComIntegradores</th>";
						$c .= "<th>ComRecibo</th>";
						$c .= "<th>CPS</th>";
						$c .= "<th>Ingreso</th>";
						$c .= "<th>CxC Proveedor</th>";
						$c .= "<th>CxP Proveedor</th>";
						$c .= "</tr>";
						$c .= "</thead>";
						$c .= "<tbody>";


					while( list($nIdCorteVentas,$dFecAltaOperacion,$nMesFecAltaOparacion,$nIdCadena,$sNombreCadena,$nIdSubCadena,$sNombreSubCadena,
			$nIdCorresponsal,$sNombreCorresponsal,$nIdProveedor,$sNombreProveedor,$nIdFamilia,$sDescFamilia,$nIdEmisor,$sDescEmisor,
			$nIdProducto,$sDescProducto,$sNumCuenta,$sCtaContable,$nVentas,$nImporte,$nRetiros,$nComCorresponsales,$nClienteCxC,$nComIntegradores,
			$nComRecibo,$nIngreso,$nCPS,$dFechaRegistro,$dFechaMovimiento,$nComOperacion,$nProveedorCxP,$sRfcCliente,$sRfcProveedor) = mysqli_fetch_array($res)){
						$d .= "<tr>";
						$d .= "<td>".$nMesFecAltaOparacion."</td>";
						$d .= "<td>".$dFecAltaOperacion."</td>";
						$d .= "<td>".$nIdCadena."</td>";
						$d .= "<td>".$sNombreCadena."</td>";
						$d .= "<td>".$nIdSubCadena."</td>";
						$d .= "<td>".$sNombreSubCadena."</td>";
						$d .= "<td>".$nIdCorresponsal."</td>";
						$d .= "<td>".$sNombreCorresponsal."</td>";
						$d .= "<td>".$sRfcCliente."</td>";
						$d .= "<td>".$nIdProveedor."</td>";
						$d .= "<td>".$sNombreProveedor."</td>";
						$d .= "<td>".$sRfcProveedor."</td>";
						$d .= "<td>".$nIdFamilia."</td>";
						$d .= "<td>".$sDescFamilia."</td>";
						$d .= "<td>".$nIdEmisor."</td>";
						$d .= "<td>".$sDescEmisor."</td>";
						$d .= "<td>".$nIdProducto."</td>";
						$d .= "<td>".$sDescProducto."</td>";
						$d .= "<td>".$sNumCuenta."</td>";
						$d .= "<td>".$sCtaContable."</td>";
						$d .= "<td>".$nVentas."</td>";
						$d .= "<td>".$nImporte."</td>";
						$d .= "<td>".$nRetiros."</td>";
						$d .= "<td>".$nComCorresponsales."</td>";
						$d .= "<td>".$nClienteCxC."</td>";
						$d .= "<td>".$nComIntegradores."</td>";
						$d .= "<td>".$nComRecibo."</td>";
						$d .= "<td>".$nCPS."</td>";
						$d .= "<td>".$nIngreso."</td>";
						$d .= "<td>".$nComOperacion."</td>";
						$d .= "<td>".$nProveedorCxP."</td>";
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
