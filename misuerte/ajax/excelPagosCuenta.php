<?php

include("../../inc/config.inc.php");
include("../../inc/session.ajax.inc.php");
include "../../inc/PhpExcel/Classes/PhpExcel.php";


	 $fechaInicio  = (!empty($_POST["fechaInicial"]))? $_POST["fechaInicial"] : 0;
     $fechaFin     = (!empty($_POST["fechaFinal"]))? $_POST["fechaFinal"] : 0;


	 $fecha1 = str_replace('-', '', $fechaInicio);
	 $fecha2 = str_replace('-', '', $fechaFin);
	 
//Nomneclatura del archivo que se descargara

	$nombre =  $fecha1."_".$fecha2."_PagosMonedero_000000016.xls";

//cabeceras de descarga de Informacion

     header("Content-type=application/x-msdownload");
	 header("Content-disposition:attachment;filename=$nombre");
	 header("Pragma:no-cache");
	 header("Expires:0");

// Se extrae la informacion de los registros que entraran en el archivo de los pagos 

        $sql = $MRDB->query("CALL `pronosticos`.`sp_select_pagos_cuenta`('$fechaInicio','$fechaFin')");
    
        $datos = array();
        $index = 0;

            while($row = mysqli_fetch_assoc($sql)){

                $datos[$index]["agencia"] = "Red Efectiva";
                $datos[$index]["concursante"] = "Red Efectiva";
                $datos[$index]["montoMonedero"] = $row["nMontoCargo"];
                $datos[$index]["fechaCargo"] = $row["dFechaContable"];
                $datos[$index]["venta"] = $row["nMontoCargo"];
                $datos[$index]["fechaVenta"] = $row["dFechaContable"];
                $datos[$index]["saldo"] = 0;
                $index++;

            }



   // Creacion del archivo de excel
	$data='';
	$data.='<table border="0" width="100%"  cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td align="center" rowspan="2">PERIODO DEL '.$fechaInicio.' AL '.$fechaFin.'</td>
				</tr>
			</table>
	<table border="2" width="100%"  cellpadding="0" cellspacing="0" align="center">
	<tr>
		<td align="center" rowspan="2" id="thFecha">NO. DE COMERCIALIZADOR Y/O AGENCIA VIRTUAL</td>
		<td align="center" rowspan="2" id="thFecha">ID DEL CONCURSANTE</td>
		<td align="center" rowspan="2" id="thFecha">MONTO DEL MONEDERO ELECTRONICO</td>
		<td align="center" rowspan="2" id="thFecha">FECHA DEL CARGO DEL MONEDERO ELECTRONICO</td>

		<td colspan="2">
			<table width="100%" style="border-collapse:collapse; ">
				<tr>
					<td align="center" colspan="2">MONEDERO ELECTRONICO</td>
				</tr>
			</table>
		</td>                                                        	
	</tr>
	<tr>
		<td width="25%" align="center">VENTAS DE M.E.</td>
		<td width="25%" align="center">FECHA DE VENTA DE M.E. </td>
		<td width="25%" align="center">SALDO</td>
	</tr>';
	for($i=0 ; $i < count($datos) ; $i++){
		$data.='
		<tr>
			<td>RED EFECTIVA</td>
			<td>RED EFECTIVA</td>
			<td>'.$datos[$i]["montoMonedero"].'</td>
			<td>'.$datos[$i]["fechaCargo"].'</td>
			<td>'.$datos[$i]["venta"].'</td>
			<td>'.$datos[$i]["fechaVenta"].'</td>
			<td>'.$datos[$i]["saldo"].'</td>
		</tr>';
		}

	$data .='</table>';

	echo $data;

?>