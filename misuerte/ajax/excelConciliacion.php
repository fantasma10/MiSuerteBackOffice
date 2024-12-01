<?php

include("../../inc/config.inc.php");
include("../../inc/session.ajax.inc.php");
include "../../inc/PhpExcel/Classes/PhpExcel.php";


	 $fechaInicio  = (!empty($_POST["fechaInicial"]))? $_POST["fechaInicial"] : 0;
     $fechaFin     = (!empty($_POST["fechaFinal"]))? $_POST["fechaFinal"] : 0;


	 $fecha1 = str_replace('-', '', $fechaInicio);
	 $fecha2 = str_replace('-', '', $fechaFin);
	 
//Nomneclatura del archivo que se descargara

	$nombre =  $fecha1."_".$fecha2."_Conciliacion.xls";

//cabeceras de descarga de Informacion

     header("Content-type=application/x-msdownload");
	 header("Content-disposition:attachment;filename=$nombre");
	 header("Pragma:no-cache");
	 header("Expires:0");

// Se extrae la informacion de los registros que entraran en el archivo de los pagos 

        $sql = $MRDB->query("CALL `pronosticos`.`sp_load_corte`('$fechaInicio','$fechaFin')");
    
        $datos = array();

        $index = 0;

            while($row = mysqli_fetch_assoc($sql)){

                $datos[$index]["monto"] = $row["monto"];
                $datos[$index]["operaciones"] = $row["operaciones"];
                $datos[$index]["fecha"] = $row["fecha"];
                $datos[$index]["nombre"]= $row["nombre"];
                $datos[$index]["metodo"]=+ $row["metodo"];
                $datos[$index]["comision"]=+ $row["comision"];
                $index++;

                $sum += $row["monto"];
                $com += $row["comision"];
                $op += $row["operaciones"];
            }


   // Creacion del archivo de excel
	$data='';
	$data.='<table border="0" width="100%"  cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td align="center" rowspan="2" colspan="4">CONCILIACION DEL '.$fechaInicio.' AL '.$fechaFin.'</td>
				</tr>
			</table>
	<table border="2" width="100%"  cellpadding="0" cellspacing="0" align="center">
	<tr>
		<td align="center">METODO DE PAGO</td>
		<td align="center">NO. OPERACIONES</td>
		<td align="center">MONTO</td>
		<td align="center">COMISION</td>
		<td align="center">FECHA DEL CORTE</td>
	</tr>';

	for($i=0 ; $i < count($datos) ; $i++){
		$data.='
		<tr>
			<td>'.$datos[$i]["nombre"].'</td>
			<td>'.$datos[$i]["operaciones"].'</td>
			<td>'.$datos[$i]["monto"].'</td>
			<td>'.$datos[$i]["comision"].'</td>
			<td>'.$datos[$i]["fecha"].'</td>
		</tr>';
		}


	$data .='</table>';

	$data .= '<table border="0" width="100%"  cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td align="center" colspan="1">TOTALES</td>
					<td align="center" colspan="1">'.$op.'</td>
					<td align="center" colspan="1">$ '.$sum.'</td>					
					<td align="center" colspan="1">$ '.$com.'</td>
				</tr>
			</table>';
	echo $data;

?>