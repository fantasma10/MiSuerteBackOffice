<?php

include("../../inc/config.inc.php");
include("../../inc/session.ajax.inc.php");
include "../../inc/PhpExcel/Classes/PhpExcel.php";


	 $fechaInicio  = (!empty($_POST["fechaInicial"]))? $_POST["fechaInicial"] : 0;
     $fechaFin     = (!empty($_POST["fechaFinal"]))? $_POST["fechaFinal"] : 0;
     $hoy = date("Y-m-d");

	 $fecha1 = str_replace('-', '', $fechaInicio);
	 $fecha2 = str_replace('-', '', $fechaFin);
	 


	$nombre =  $fecha1."_".$fecha2."_PremiosDeterminadosVirtuales_000000016.xls".
//cabeceras de desacarga de Informacion

     header("Content-type=application/x-msdownload");
	 header("Content-disposition:attachment;filename=$nombre");
	 header("Pragma:no-cache");
	 header("Expires:0");

//Se extrae la informacion de los registros que entraran en el archivo de excel segun las fechas seleccionadas

	$sql = $MRDB->query("CALL `pronosticos`.`sp_select_pagos_premios`('$fechaInicio','$fechaFin')");
   
        $datos = array();
        $index = 0;

            while($row = mysqli_fetch_assoc($sql)){

                $datos[$index]["agencia"] = $row["sAgencia"];
                $datos[$index]["concursante"] = $row["sUsuario"];       
                $datos[$index]["premio"] = $row["nSaldoBruto"];
                $datos[$index]["dispersion"] = $row["dFechaUltPremio"];
                $datos[$index]["premioPagado"] = $row["nSaldoNeto"];
                $datos[$index]["fechaPago"] = $row["dFechaPagoPremio"];
                $datos[$index]["venta"] = $row["nMontoVenta"];
                $datos[$index]["fechaVenta"] = $row["dFechaVenta"];
                $datos[$index]["saldo"] = $row["nSaldoFinal"];
                $index++;
                
            }
	

//Extraemos la configuracion de la cual se tomara el correo e informacion que llevara el correo
/*
	$sql2 = $MRDB->query("CALL `pronosticos`.`sp_select_cfg_tarea`('3')");
   
        $index = 0;

        $array_correos = array();

            while($row = mysqli_fetch_assoc($sql2)){

            	$correos 	= $row['sCorreoDestino'];
            	$asunto 	= $row['sAsunto'];
            	$path 		= $row['sPathArchivos'];
            	$contenido 	= $row['sContenido'];
            	$correoSalida 	= $row['sCorreo'];


                
            }
	

            // Se extraen los correos en caso de existir mas de uno y son separados por coma
	$array_correos =  explode(",", $correos);
*/

//Se genera el archivo a enviar 

	$data='';
	$data.='<table border="0" width="100%"  cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td align="center" rowspan="2" id="thFecha">PERIODO DEL '.$fechaInicio.' AL '.$fechaFin.'</td>
				</tr>
			</table>
	<table border="2" width="100%"  cellpadding="0" cellspacing="0" align="center">
	<tr>
		<td align="center" rowspan="2" id="thFecha">NO. DE COMERCIALIZADOR Y/O AGENCIA VIRTUAL</td>
		<td align="center" rowspan="2" id="thFecha">ID DEL CONCURSANTE</td>
		<td align="center" rowspan="2" id="thFecha">PREMIOS DETERMINADOS POR CONCURSANTE GANADOR</td>
		<td align="center" rowspan="2" id="thFecha">FECHA DE DISPERSI&Oacute;N DE PREMIOS DETERMINADOS	</td>

		<td colspan="4" id="thFecha">
			<table width="100%" style="border-collapse:collapse; ">
				<tr>
					<td align="center" colspan="4">MONTO VIRTUAL</td>
				</tr>
			</table>
		</td>                                                        	
	</tr>
	<tr>
		<td width="25%" align="center">PREMIOS EFECTIVAMENTE PAGADOS</td>
		<td width="25%" align="center">FECHA DE PAGO DE PREMIOS</td>
		<td width="25%" align="center">VENTAS DE M.V.</td>
		<td width="25%" align="center">FECHA DE VENTA </td>
		<td width="25%" align="center">SALDO</td>
	</tr>';
	for($i=0 ; $i < count($datos) ; $i++){
		$data.='
		<tr>
			<td id="thFecha">'.$datos[$i]["agencia"].'</td>
			<td id="thFecha">'.$datos[$i]["concursante"].'</td>
			<td id="thFecha">'.$datos[$i]["premio"].'</td>
			<td id="thFecha">'.$datos[$i]["dispersion"].'</td>

			<td  id="thFecha">'.$datos[$i]["premioPagado"].'</td>
			<td id="thMonto">'.$datos[$i]["fechaPago"].'</td>
			<td id="td1">'.$datos[$i]["venta"].'</td>
			<td id="td1">'.$datos[$i]["fechaVenta"].'</td>
			<td id="td1">'.$datos[$i]["saldo"].'</td>
		</tr>';
		}

	$data .='</table>';

	echo $data;

/*
	$nuevaRuta = $path;     //Se extrae el directorio en el cual se guardara el nuevo archivo
	$arrFecha = explode('-', $hoy);   
	$año = $arrFecha[0];   
	$año = substr($año, 2); 
	$mes = $arrFecha[1];    
	$dia = $arrFecha[2];    
	$renFile = $dia.$mes.$año."_PremiosDeterminadosVirtuales.xls";


	if(!file_exists("$nuevaRuta")) 
		mkdir("$nuevaRuta");

	if(!file_exists("$nuevaRuta/$año$mes")) 
		mkdir("$nuevaRuta/$año$mes");
	
	$nvoArchivo = "$nuevaRuta/$año$mes/$renFile";

	$shtml= $data;
	$sfile=$nvoArchivo;    //ruta del archivo a generar
	$fp=fopen($sfile,"w"); //abre el archivo en memoria
	fwrite($fp,$shtml);    //escribe el contenido
	fclose($fp);           //cierra el archivo
*/

/*
	if(count($array_correos) > 0){

		include($_SERVER['DOCUMENT_ROOT']."/inc/lib/phpmailer/class.phpmailer.php");

		//se inicializan variables de configuracion del correo
		$oMailHandler = new Mail();
		$oMailHandler->setNAutorizador("");
		$oMailHandler->setSIp("");
		$oMailHandler->setOLog($LOG);
		$oMailHandler->setORdb($MRDB);
		$oMailHandler->setSSistema("DEF");
		$oMailHandler->setSFrom($correoSalida);
		$oMailHandler->setSName("Red Efectiva");
		$oMailHandler->setOMail();
		$oMailHandler->setMail();

		$oMailHandler->oMail->SMTPDebug = 0;
		$oMailHandler->oMail->Port		= $N_SMTP_PORT;
		$oMailHandler->oMail->Debugoutput = 'var_dump';


		//Se recorre el arreglo del correo para extraer y adjuntar en las direcciones de correo donde se enviara el archivo

		foreach($array_correos as $sCorreo){

			$oMailHandler->oMail->AddAddress($sCorreo);

		}

		$archivo = $sfile;
        $oMailHandler->oMail->AddAttachment($archivo,$renFile);
		$oMailHandler->oMail->addReplyTo($correoSalida, 'Sistemas');
		$oMailHandler->oMail->CharSet = 'UTF-8';
		$oMailHandler->oMail->Subject = $asunto;
		$oMailHandler->oMail->isHTML(true);
		$oMailHandler->oMail->Body = $contenido;

		if($oMailHandler->oMail->Send()){
			echo json_encode(array(
				"nCodigo"			=> 0,
				"bExito"			=> true,
				"sMensaje"			=> "Email enviado exitosamente."
				));
		//echo '<pre>'; var_dump($oMailHandler->oMail); echo '</pre>';

		}else{
			echo json_encode(array(
				"nCodigo"			=> 500,
				"bExito"			=> false,
				"sMensaje"			=> "No fue posible enviar el Email.",
				"sMensajeDetallado"	=> $oMailHandler->oMail->ErrorInfo
				));
		//echo '<pre>'; var_dump($oMailHandler->oMail); echo '</pre>';
		}

		$oMailHandler->oMail->__destruct();
	


	}else{

		echo json_encode(array(
				"nCodigo"			=> 0,
				"bExito"			=> true,
				"sMensaje"			=> "No se encontro la configuracion para el correo"
				));

	}*/
?>