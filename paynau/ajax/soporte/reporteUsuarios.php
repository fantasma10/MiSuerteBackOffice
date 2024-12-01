<?php
include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");



if ($_POST){
	

    
    $fechaInicio=!empty($_POST["h_dFechaInicio"])? $_POST["h_dFechaInicio"]:'0000-00-00'; //
    $fechaFin=!empty($_POST["h_dFechaFin"])? $_POST["h_dFechaFin"]:'0000-00-00';
	

	

	$sumMovimientos=0;
	$sumImporte=0;
	$sumComision=0;
	$sumTrasferencia=0;
	$sumNeto=0;
		
		$array_params = array(
			array(
				'name'	=> 'PO_dFecInicio',
				'type'	=> 's',
				'value'	=> $fechaInicio
			),array(
				'name'	=> 'PO_dFecFin',
				'type'	=> 's',
				'value'	=> $fechaFin
			)
		);
			
		
		
		$oRDPN->setSDatabase('paycash_one');
		$oRDPN->setSStoredProcedure('sp_select_reporte_usuarios');
		$oRDPN->setParams($array_params);

		$result = $oRDPN->execute();
		$registros = $oRDPN->numRows();
		
		$data = $oRDPN->fetchAll();

		$data =utf8ize($data);
		$titulo='Usuarios Paynau';

			$colors = '';
			$i = 0;
			$reporte='<table  width="100%"  cellpadding="0" id="reporte" cellspacing="0" align="center">
			<tr>
			<td colspan="13" align="center"><span style="font-weight:bold;">Reporte </span><span id="nombreEmisor" style="font-weight:bold;">'.$titulo.' </span></td>
			</tr>
			<tr>
				<td rowspan="2" colspan="10" align="left"><span style="font-weight:bold;"></span></td>
				<td colspan="3" align="right"><span style="font-weight:bold;font-size:15px;">Red Efectiva S.A. de C.V.</span></td>
			</tr>
			<tr>
				<td colspan="3" align="right"><span style="font-size:13px;">Blvd. Antonio L. Rdz 3058 Suite 201-A</span></td>
			</tr>
			<tr>
				<td colspan="10" align="left" style=""><span style="font-weight:bold;">REPORTE DE USUARIOS</span></td>
				<td colspan="3" align="right"><span style="font-size:13px;">Colonia Santa Maria</span></td>
			</tr>
			<tr>
				<td colspan="10"></td>
				<td colspan="3" align="right"><span style="font-size:13px;">Monterrey, N.L. C.P. 64650</span></td>
			</tr>
			<tr>
				<td colspan="10"><span style="font-weight:bold;">Periodo de </span><span id="fechaInicial" style="font-weight:bold;">'.$fechaInicio.'</span> <span style="font-weight:bold;">a</span> <span id="fechaFinal" style="font-weight:bold;">'.$fechaFin.'</span></td>
			</tr>
			<tr>
			<td colspan="10" align="left"><span style="font-weight:bold;">Resumen De registros</span></td>
			</tr>';
			
           

			$detalleOperaciones ='<tr style="background-color: #b7b7d4; ">
				 <td align="center">Id Usuario</td>
                 <td align="center">Id Proveedor</td>
				 <td align="center">Estatus Registro</td>
				 <td align="center">'.utf8_decode("Confimación Correo").'</td>
				 <td align="center">Razon Social</td>
				 <td align="center">Nombre Comercial</td>
				 <td align="center">RFC</td>
				 <td align="center">Telefono</td>
				 <td align="center">Celular</td>
				 <td align="center">Correo</td>
				 <td align="center">Fecha de Registro</td>
				 <td align="center">No. Subcomercio</td>
				 <td align="center">'.utf8_decode("Paquete Suscripción").'</td>
                 
			</tr>';
			
			$reporte = $reporte .$detalleOperaciones ;
			foreach ($data as $value) {

				if (0 == $i % 2) {
                	$colors = "background-color:#ffffff;";
            	}else{
                	$colors = "background-color:#d6e1ff;";
            	}
            	
				$i++;

				$reporte .= '    <tr style="'.$colors.'">
				<td align="center" >'.($value["nIdUsuario"]).'</td>
				<td align="center" >'.($value["nIdProveedor"]).'</td>
				<td align="center" >'.($value["EstatusRegistro"]).'</td>
				<td align="center" >'.($value["ConfimacionCorreo"]).'</td>
				<td align="center" >'.utf8_decode($value["sRazonSocial"]).'</td>
				<td align="center" >'.utf8_decode($value["sNombreComercial"]).'</td>
				<td align="center" >'.($value["RFC"]).'</td>
				<td align="center" >'.($value["sTelefono"]).'</td>
				<td align="center" >'.($value["sCelular"]).'</td>
				<td align="center" >'.($value["sCorreo"]).'</td>
				<td align="center" >'.($value["dFecRegistro"]).'</td>
				<td align="center" >'.utf8_decode($value["nSubcomercio"]).'</td>
				<td align="center" >'.utf8_decode($value["sPaqueteSuscripcion"]).'</td>
			</tr>';   
			}
			if($registros == 0){
				$reporte .= '<tr style=" background-color: #d6e1ff; font-weight:bold"><td colspan="13" align="center"><span style="font-weight:bold;">No se econtraron registros en este periodo, seleccione un rango mayor de fechas</span></td></tr>';
			}
			$reporte .= '<tr style=" background-color: #b7b7d4; font-weight:bold">
			</tr>
			</table>';     


			header("Content-type=application/x-msdownload");
			header("Content-disposition:attachment;filename=ReporteUsuarios.xls");
			header("Pragma:no-cache");
			header("Expires:0");
			echo ($reporte);

		
	}
