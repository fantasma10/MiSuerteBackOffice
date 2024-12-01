<?php
ini_set("soap.wsdl_cache_enabled", "0");
include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session2.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");
include_once $_SERVER['DOCUMENT_ROOT']."/inc/PHPExcel/Classes/PHPExcel.php";
include_once($_SERVER['DOCUMENT_ROOT'].'/inc/lib/PHPMailer/PHPMailerAutoload.php');
include($_SERVER['DOCUMENT_ROOT']."/_Proveedores/reportes/ajax/RE_GeneraExcelTelmex.class.php");
include($_SERVER['DOCUMENT_ROOT']."/_Proveedores/reportes/ajax/RE_GeneraTxtTelmex.class.php");

//VARIABLES PARA GAS NATURAL
$METROGAS = 119;
$GASNATURAL=27;


function getListaCorreos($proveedor,$conexion){
    $mensaje="";
    $estatus = 1;
    $queryCorreos ="CALL `redefectiva`.`sp_getCorreosProveedor`($proveedor);";
    $resultadoCorreos = $conexion->query($queryCorreos);
    $listaCorreos="";
    while($rowCorreos = mysqli_fetch_assoc($resultadoCorreos)){
        $correos = $rowCorreos["correos"];
        $listaCorreos = $rowCorreos["correos"];
    }

    if(empty($listaCorreos)){
        $mensaje = "";
        $estatus = 1;
    }else{
        $mensaje = $listaCorreos;
        $estatus = 0;
    }

    $arrayRespuesta["mensaje"] = $mensaje;
    $arrayRespuesta["estatus"] = $estatus;

    return $arrayRespuesta;
}

function envio_correo($nombreArchivo,$correos){
    $oMailHandler = new Mail();
    $oMailHandler->setNAutorizador("");
    $oMailHandler->setSIp("");
    $oMailHandler->setOLog($oLog);
    $oMailHandler->setORdb($oRdb);
    $oMailHandler->setSSistema("DEF");
    $oMailHandler->setSFrom('sistemas@redefectiva.com');
    $oMailHandler->setSName("Red Efectiva");
    $oMailHandler->setOMail();
    $oMailHandler->setMail();

    $oMailHandler->oMail->SMTPDebug = 0;
    $oMailHandler->oMail->Port = $N_SMTP_PORT;
    $oMailHandler->oMail->Debugoutput = 'var_dump';

    $destinatarios = explode(",", $correos); //correos que llegan
    $i = 0;
    //solo se envia a contabilidad 
    /*while ($i < count($destinatarios)) {
    	$correoClean = str_replace("'", "", $destinatarios[$i]);
        $oMailHandler->oMail->AddAddress($correoClean);
        $i++;
    }*/
    $oMailHandler->oMail->AddAddress(EMAIL_CONTABILIDAD);
    $oMailHandler->oMail->CharSet = 'UTF-8';
    $oMailHandler->oMail->Subject = "Reporte de Cobranza";
    $oMailHandler->oMail->isHTML(true);
    
    $body = "Hola Estimados, Buen Dia."."<br><br>";
    $body .= "Les adjuntamos el archivo"."<br><br>";
    $body .="Saludos"; 

    $oMailHandler->oMail->addAttachment($nombreArchivo);            
    $oMailHandler->oMail->Body = $body;

    if($oMailHandler->oMail->Send()){
        $data=array(
            "bExito"            => true,
            "sMensaje"          => "Email enviado exitosamente."
        );
        return $data;
    }
    else{
        $data=array(
            "bExito"            => false,
            "sMensaje"          => "No fue posible enviar el Email.",
            "sMensajeDetallado" => $oMailHandler->oMail->ErrorInfo
        );
        return $data;
    }
}

$tipo  = (!empty($_POST["tipo"]))? $_POST["tipo"] : 0;

$proveedorArray = array();
$fechasArray = array();
$arregloProveedor="";
$arregloFecha ="";
/*
case 1: Lista de proveedores
case 2: obtiene el reporte de cortes        
case 3: obtiene el reporte en dias de liquidacione
case 4: obtiene las operaciones que se fueron aclaracion
case 5: obtiene el reporte de las operaciones de un dia               
case 6: inserta aclaracion
case 7: cerrar corte
case 8: autoriza corte
case 9: rechaza corte
case 10: Actualiza una aclaracion
case 11: Armado de layout multiCortes
case 12: cerrar corte multiple
case 13: autorizar corte multiple
*/

switch ($tipo) {
    case 1:
        $array_params = array(array('name' => 'p_idProveedor', 'value' => 0, 'type' =>'i'));
    	$oRdb->setSDatabase('redefectiva');
    	$oRdb->setSStoredProcedure('sp_select_proveedor');
    	$oRdb->setParams($array_params);
    	$result = $oRdb->execute();
    	if ( $result['nCodigo'] ==0){
    	  	$data = $oRdb->fetchAll();
    	   	$datos = array();
    	   	$index = 0;
    		for($i=0;$i<count($data);$i++){
                if ($data[$i]['idEstatusProveedor'] == 0) {
    			    $datos[$index]["idProveedor"] = $data[$i]["idProveedor"];
    			    $datos[$index]["nombreProveedor"] = utf8_encode($data[$i]["nombreProveedor"]);
    			    $index++;
                }
    		}
    		$oRdb->closeStmt();
    		$totalDatos = $oRdb->foundRows();
    		$oRdb->closeStmt();
    	}else{
    	   	$datos = 0;
    	}		
    	echo json_encode($datos);
        break;

    case 2:
		$proveedor =$_POST["proveedor"];
		$fechaIni =$_POST["fechaIni"];
		$fechaFin =$_POST["fechaFin"];
		$fechaTipo =$_POST["fechaTipo"];
        
        $totOpe=0;
        $totMonto=0;
        $totCom=0;
        $totPago=0;
        
		$nStart		= (!empty($_POST["iDisplayStart"]))? $_POST["iDisplayStart"]   : 0;
		$nLimit 	= (!empty($_POST["iDisplayLength"]))? $_POST["iDisplayLength"] : 10;
		$sBuscar    = !empty($_POST['sSearch']) ? trim($_POST['sSearch']) : '';
		$array_params = array(
			array('name' => 'p_idProveedor',	'value' => $proveedor,		'type' => 'i'),
			array('name' => 'p_fechaIni',		'value' => $fechaIni,		'type' => 's'),
			array('name' => 'p_fechaFin',		'value' => $fechaFin,		'type' => 's'),
			array('name' => 'p_start',			'value' => $nStart,			'type' => 'i'),
	      	array('name' => 'p_limit',			'value' => $nLimit,			'type' => 'i'),
	      	array('name' => 'p_buscar',			'value' => $sBuscar,		'type' => 's'),
	      	array('name' => 'p_tipo',			'value' => 0,				'type' => 'i'),
	      	array('name' => 'p_fechaTipo',		'value' => $fechaTipo,		'type' => 'i')  
		);

        $oRdb->setSDatabase('redefectiva');
	    $oRdb->setSStoredProcedure('sp_select_corte_proveedor');
	    $oRdb->setParams($array_params);
	    $result = $oRdb->execute();
	    $data = $oRdb->fetchAll();
	   	if ( $result['nCodigo'] ==0){
	    	$datos = array();
	    	$index = 0;
			for($i=0;$i<count($data);$i++){

                $datos[$index]["nIdCorte"] = $data[$i]["nIdCorte"];
                $datos[$index]["nZona"] = $data[$i]["nZona"];
                $datos[$index]["sNombreZona"] =  utf8_encode($data[$i]["sNombreZona"]);
                $datos[$index]["nIdEstatus"] = $data[$i]["nIdEstatus"];
                $datos[$index]["nIdProveedor"] = $data[$i]["nIdProveedor"];
				$datos[$index]["nombreProveedor"] = utf8_encode($data[$i]["nombreProveedor"]);
				$datos[$index]["nTotalOperaciones"] = $data[$i]["nTotalOperaciones"];
				$datos[$index]["nTotalMonto"] = "$".number_format($data[$i]["nTotalMonto"],2,'.',',');
                $datos[$index]["nTotalMonto2"] = $data[$i]["nTotalMonto"];
				$datos[$index]["nTotalComision"] = "$".number_format($data[$i]["nTotalComision"],2,'.',',');
                $datos[$index]["nTotalComision2"] = $data[$i]["nTotalComision"];
				$datos[$index]["nTotalPago"] = "$".number_format($data[$i]["nTotalPago"],2,'.',',');
                $datos[$index]["nTotalPago2"] = $data[$i]["nTotalPago"];
                $datos[$index]["nComisionCxP"] = "$".number_format($data[$i]["nComisionCxP"],2,'.',',');
                $datos[$index]["nComisionCxP2"] = $data[$i]["nComisionCxP"];
				$datos[$index]["dFecha"] = $fechaTipo == 1 ? $data[$i]["dFecha"]: "";
				$datos[$index]["dFechaPago"] = $data[$i]["dFechaPago"];
                $datos[$index]["nEnviaReporte"] = $data[$i]["nEnviaReporte"];               
                $datos[$index]["razonSocial"] = utf8_encode($data[$i]["razonSocial"]); 
                $datos[$index]["nImporteTransferencia"] = "$".number_format($data[$i]["nImporteTransferencia"],2,'.',','); 
                $datos[$index]["nImporteTransferencia2"] = $data[$i]["nImporteTransferencia"];               
				$index++;
			}
			$oRdb->closeStmt();
			$totalDatos = $oRdb->foundRows();
			$oRdb->closeStmt();
	    }else{
	    	$datos = 0;
	    	$totalDatos = 0;
	    }

        $resultado = array(
            //"detalle_consulta"=> $result,
            "iTotalRecords"     => $totalDatos,
            "iTotalDisplayRecords"  => $totalDatos,
            "aaData"        => $datos
        );

	   echo json_encode($resultado);
        break;
    
    case 3:
        $proveedor = $_POST["proveedor"];
        $fechaIni = $_POST["fechaIni"];
        $fechaFin = $_POST["fechaFin"];
        $nStart     = (!empty($_POST["iDisplayStart"]))? $_POST["iDisplayStart"]   : 0;
        $nLimit     = (!empty($_POST["iDisplayLength"]))? $_POST["iDisplayLength"] : 10;
        $sBuscar    = !empty($_POST['sSearch']) ? trim($_POST['sSearch']) : '';
        

        $oRdb->setSDatabase('redefectiva');
        $array_params = array(
            array('name' => 'p_proveedor',  'value' => $proveedor,  'type' => 'i'),
            array('name' => 'p_fechaIni',   'value' => $fechaIni,   'type' => 's'),
            array('name' => 'p_fechaFin',   'value' => $fechaFin,   'type' => 's'),
            array('name' => 'p_start',      'value' => $nStart,   'type' => 's'),
            array('name' => 'p_limit',      'value' => $nLimit,   'type' => 's'),
            array('name' => 'p_buscar',     'value' => $sBuscar,   'type' => 's'),
        );


        $oRdb->setSStoredProcedure('sp_select_liquidacion_proveedor');
        $oRdb->setParams($array_params);
        $result = $oRdb->execute();
        if ( $result['nCodigo'] ==0){
            $data = $oRdb->fetchAll();
            $datos = array();
            $index = 0;
            for($i=0;$i<count($data);$i++){ 
                $datos[$index]["nZona"] = $data[$i]["nZona"];
                $datos[$index]["sNombreZona"] = utf8_encode($data[$i]["sNombreZona"]);
                $datos[$index]["nIdProveedor"] = $data[$i]["nIdProveedor"];
                $datos[$index]["nombreProveedor"] = utf8_encode($data[$i]["nombreProveedor"]);
                $datos[$index]["nTotalOperaciones"] = $data[$i]["nTotalOperaciones"];
                $datos[$index]["nTotalMonto"] = "$".number_format($data[$i]["nTotalMonto"],2,'.',',');
                $datos[$index]["nTotalMonto2"] = $data[$i]["nTotalMonto"];
                $datos[$index]["nTotalComision"] = "$".number_format($data[$i]["nTotalComision"],2,'.',',');
                $datos[$index]["nTotalComision2"] = $data[$i]["nTotalComision"];
                $datos[$index]["nTotalPago"] = "$".number_format($data[$i]["nTotalPago"],2,'.',',');
                $datos[$index]["nTotalPago2"] = $data[$i]["nTotalPago"];
                $datos[$index]["dFechaPago"] = $data[$i]["dFechaPago"];
                $datos[$index]["nEnviaReporte"] = $data[$i]["nEnviaReporte"];
                $datos[$index]["envioCorreo"] = $data[$i]["envioCorreo"];
                $index++;
            }
            $oRdb->closeStmt();
            $totalDatos = $oRdb->foundRows();
            $oRdb->closeStmt();
        }else{
            $datos = 0;
            $totalDatos = 0;
        }
        $resultado = array(
            "detalle_consulta"=> $result,
            "iTotalRecords"     => $totalDatos,
            "iTotalDisplayRecords"  => $totalDatos,
            "aaData"        => $datos           
        );
        echo json_encode($resultado);
        break;

    case 4:
        $idProveedor = $_POST["idProveedor"];
        $fechaPago   = $_POST["fechaPago"];
        $nStart     = (!empty($_POST["iDisplayStart"]))? $_POST["iDisplayStart"]   : 0;
        $nLimit     = (!empty($_POST["iDisplayLength"]))? $_POST["iDisplayLength"] : 10;
        $sBuscar    = !empty($_POST['sSearch']) ? trim($_POST['sSearch']) : '';
        
        $oRdb->setSDatabase('redefectiva');
        $array_params = array(
            array('name' => 'p_idProveedor',    'value' => $idProveedor,  'type' => 'i'),
            array('name' => 'p_fecha',          'value' => $fechaPago,   'type' => 's'),
            array('name' => 'p_start',          'value' => 0,         'type' => 'i'),
            array('name' => 'p_limit',          'value' => -1,        'type' => 'i'),
            array('name' => 'p_buscar',         'value' => $sBuscar,  'type' => 's'),
        );


        $oRdb->setSStoredProcedure('sp_getAclaraciones_Tarea');
        $oRdb->setParams($array_params);
        $result = $oRdb->execute();
        if ( $result['nCodigo'] ==0){
            $data = $oRdb->fetchAll();
            $datos = array();
            $index = 0;
            for($i=0;$i<count($data);$i++){
                $datos[$index]["nIdCorte"] = $data[$i]["nIdCorte"];
                $datos[$index]["nIdProveedor"] = $data[$i]["nIdProveedor"];
                $datos[$index]["nombreProveedor"] = utf8_encode($data[$i]["nombreProveedor"]);
                $datos[$index]["dFechaCorte"] = $data[$i]["dFechaCorte"];
                $datos[$index]["nIdsOperacion"] = $data[$i]["nIdsOperacion"];
                $datos[$index]["nMonto"] = "$".number_format($data[$i]["nMonto"],2,'.',',');
                $datos[$index]["sConcepto"] = utf8_encode($data[$i]["sConcepto"]);
                $datos[$index]["tipoOperacion"] = $data[$i]["tipoOperacion"];
                $index++;
            }
            $oRdb->closeStmt();
            $totalDatos = $oRdb->foundRows();
            $oRdb->closeStmt();
        }else{
            $datos = 0;
            $totalDatos = 0;
        }
        $resultado = array(
            "detalle_consulta"=> $result,
            "iTotalRecords"     => $totalDatos,
            "iTotalDisplayRecords"  => $totalDatos,
            "aaData"        => $datos           
        );

        
        echo json_encode($resultado);
        break;

    case 5:
		$idProveedor = $_POST["idProveedor"];
		$fecha = $_POST["fecha"];
        $zonaReferencia = $_POST["zonaReferencia"];
        if(empty($zonaReferencia)){
            $zonaReferencia="0";
        }
		$nStart		= (!empty($_POST["iDisplayStart"]))? $_POST["iDisplayStart"]   : 0;
		$nLimit 	= (!empty($_POST["iDisplayLength"]))? $_POST["iDisplayLength"] : 10;
		$sBuscar    = !empty($_POST['sSearch']) ? trim($_POST['sSearch']) : '';

		$estatusOperacion = $_POST["estatusOperacion"];
		$array_params = array(
			array('name' => 'p_idProveedor',	'value' => $idProveedor,		'type' =>'i'),
			array('name' => 'p_fecha',		    'value' => $fecha,				'type' =>'s'),
			array('name' => 'p_start',		    'value' => $nStart,				'type' =>'i'),
			array('name' => 'p_limit',		    'value' => $nLimit,				'type' =>'i'),
			array('name' => 'p_buscar',		    'value' => $sBuscar,			'type' =>'s'),
			array('name' => 'p_estatus',		'value' => $estatusOperacion,	'type' =>'i'),
            array('name' => 'p_referenciaZona', 'value' => $zonaReferencia,     'type' =>'i'),
		);


        $oRdb->setSDatabase('redefectiva');
	    $oRdb->setSStoredProcedure('sp_get_ops_operacion');
	    $oRdb->setParams($array_params);
	    $result = $oRdb->execute();
	   	if ( $result['nCodigo'] ==0){
	    	$data = $oRdb->fetchAll();
	    	$datos = array();
	    	$index = 0;
			for($i=0;$i<count($data);$i++){
				$datos[$index]["idOperacion"] = $data[$i]["idOperacion"];
				$datos[$index]["ticket"] = utf8_encode($data[$i]["ticket"]);
				$datos[$index]["nombreCadena"] = utf8_encode($data[$i]["nombreCadena"]);
				$datos[$index]["nombreCorresponsal"] = utf8_encode($data[$i]["nombreCorresponsal"]);
				$datos[$index]["importeOperacion"] = "$".number_format($data[$i]["importeOperacion"],2,'.',',');
				$datos[$index]["idEstatusOperacion"] = utf8_encode($data[$i]["idEstatusOperacion"]);
				$datos[$index]["evaluacion"] = utf8_encode($data[$i]["evaluacion"]);
                $datos[$index]["sConcepto"] = utf8_encode($data[$i]["sConcepto"]);
                $datos[$index]["referencia1Operacion"] = utf8_encode($data[$i]["referencia1Operacion"]);
				$index++;
			}
			$oRdb->closeStmt();
			$totalDatos = $oRdb->foundRows();
			$oRdb->closeStmt();
	    }else{
	    	$datos = 0;
	    	$totalDatos = 0;
	    }
		$resultado = array(
		    "iTotalRecords"     => $totalDatos,
		    "iTotalDisplayRecords"  => $totalDatos,
		    "aaData"        => $datos		    
		);
	    echo json_encode($resultado);
        break;

    case 6:
    	$corte = $_POST["corte"];
    	$idOperacion = $_POST["idOperacion"];
    	$idProveedor = $_POST["idProveedor"];
    	$concepto = utf8_decode($_POST["concepto"]);
    	$monto = $_POST["monto"];
    	$tipoOperacion = $_POST["tipoOperacion"];
    	$idUsuario = $_SESSION["idU"];
    	$fechaP = $_POST["fechaP"];
        $referenciaZona = $_POST["referenciaZona"];
        if(empty($referenciaZona)){
            $referenciaZona="";
        }
    	$query = "CALL `redefectiva`.`sp_insert_aclaracion`($corte,$idOperacion,$idProveedor,'$concepto','$monto',$tipoOperacion,$idUsuario,'$fechaP','$referenciaZona');";


    	$resultado = $oWdb->query($query);
    	$mensaje="";
    	$estatus="";
        
    	while ($row = mysqli_fetch_assoc($resultado)) { 
    		$mensaje = $row["@mensaje"];
    		$estatus = $row["@estatus"];
    	}
    	echo json_encode(array(
    		"Mensaje"   => $mensaje,
    		"Estatus" 	=> $estatus
    	));
        break;

    case 7:
        $corte = $_POST["corte"];
        $proveedor = $_POST["proveedor"];
        $zona     = (!empty($_POST["zona"]))? $_POST["zona"]  : 0;
        $fecha = date("Y-m-d");

        $usuario = $_SESSION["idU"];
        $query = "CALL `redefectiva`.`sp_update_corte_proveedor`(0,$corte,$proveedor,$zona,'$fecha',NULL,2);";
        
        $resultado = $oWdb->query($query);
        $respuesta="";
        $estatus="";
        while ($row = mysqli_fetch_assoc($resultado)) { 
            $respuesta = $row["mensaje"];
            $estatus = $row["estatus"];
        }
        echo json_encode(array(
            "respuesta" => $respuesta,
            "estatus" => $estatus
        ));
        break;

    case 8:
    	$proveedor = $_POST["proveedor"];
    	$fechaPago = $_POST["fechaPago"];
        $zona = $_POST["zona"];
    	$bError=false;
        $rechazo = array();
        $fecha = date("Y-m-d");

        //valida que los cortes esten en estatus de cerrado => distinto de estatus 1
    	$query = "CALL `redefectiva`.`sp_getEstatusCorte`(1,0,$proveedor,$zona,'$fechaPago',1);";
        $resultado = $oRdb->query($query);
        $num=0;
        $resp = mysqli_fetch_row($resultado);
        $num=$resp[0];
                
        if($num > 0){
            $bError=true;
            $rechazo[]="ALGUN CORTE NO CERRADO";
        }

        //valida que los cortes no esten rechazados => en estatus 4
        $query = "CALL `redefectiva`.`sp_getEstatusCorte`(1,0,$proveedor,$zona,'$fechaPago',4);";
        $resultado = $oRdb->query($query);
        $num=0;
        $resp = mysqli_fetch_row($resultado);
        $num=$resp[0];
        
        if($num > 0){
            $bError=true;
            $rechazo[]="ALGUN CORTE ESTA RECHAZADO";
        }

        //valida que los cortes no esten previamente autorizados=> en estatus 3
        $query = "CALL `redefectiva`.`sp_getEstatusCorte`(1,0,$proveedor,$zona,'$fechaPago',3);";
        $resultado = $oRdb->query($query);
        $num=0;
        $resp = mysqli_fetch_row($resultado);
        $num = $resp[0];
        
        if($num > 0){
            $bError=true;
            $rechazo[]="ALGUN CORTE YA FUE AUTORIZADO";
        }

        if(!$bError){
             $query = "CALL `redefectiva`.`sp_update_corte_proveedor`(1,0,$proveedor,$zona,'$fecha','$fechaPago',3);";
            $resultado = $oWdb->query($query);
            $autorizo =1 ;
            while ($row = mysqli_fetch_assoc($resultado)) { 
                $autorizo = $row["estatus"];
                $respuesta["nCodigo"] = $row["estatus"];
                $respuesta["sMensaje"] = $row["mensaje"];
            }
            if($autorizo == 0){
                $query = "CALL `redefectiva`.`sp_insert_historial_envios`($proveedor,$zona,'$fechaPago');";
                $resultado = $oWdb->query($query);
            }

            if($respuesta["nCodigo"]==0){// generar archivos y enviar por correo
                
                $oGeneraExcelTelmex = new RE_GeneraExcelTelmex();//aplica para gas natural y telmex
                $oGeneraExcelTelmex->setNIdProveedor($proveedor);
                $oGeneraExcelTelmex->setNIdZona($zona);
                $oGeneraExcelTelmex->setDFechaPago($fechaPago);
                $oGeneraExcelTelmex->setORdb($oRdb);
                $oGeneraExcelTelmex->setOWdb($oWdb);
                $oGeneraExcelTelmex->setOLog($LOG); 
                $respuestaExcel = $oGeneraExcelTelmex->generaExcel();
                    
                $oGeneraTxtTelmex = new RE_GeneraTxtTelmex();//aplica para gas natural y telmex
                $oGeneraTxtTelmex->setNIdProveedor($proveedor);
                $oGeneraTxtTelmex->setNIdZona($zona);
                $oGeneraTxtTelmex->setDFechaPago($fechaPago);
                $oGeneraTxtTelmex->setORdb($oRdb);
                $oGeneraTxtTelmex->setOWdb($oWdb);
                $oGeneraTxtTelmex->setOLog($LOG); 
                $respuestaTxt = $oGeneraTxtTelmex->generaTxt();                

                if($respuestaExcel['retorno'] == 0 && $respuestaTxt['retorno'] == 0){
                    $dir=$_SERVER['DOCUMENT_ROOT']."/STORAGE/RED_EFECTIVA/TELMEX/";
                    $ruta_archivo_excel = $respuestaExcel['ruta_archivo'];
                    $nombre_archivo_excel = $respuestaExcel['nombre_archivo'];
                    $ruta_archivo_txt = $respuestaTxt['ruta_archivo'];
                    $nombre_archivo_txt = $respuestaTxt['nombre_archivo'];

                    //genera el zip de los archivos
                    $zip = new ZipArchive();
                    $nameZip = "RCT_".$proveedor."_".$fechaPago.".zip";
                    if ($zip->open($dir.$nameZip, ZipArchive::CREATE)!==TRUE) {
                        $mensaje = "Error al generar el archivo comprimido";
                        $estatus = 1;
                    }else{
                        $zip->addFile($ruta_archivo_excel,$nombre_archivo_excel);
                        $zip->addFile($ruta_archivo_txt,$nombre_archivo_txt);
                        $zip->close();
                    }
                    
                    //envia email correos
                    $correosRespuesta = getListaCorreos($proveedor,$oRdb);
                    if($correosRespuesta["estatus"] ==0 ){
                        $correos = $correosRespuesta["mensaje"];
                        $envioCorreo = envio_correo($dir.$nameZip,$correos);
                        if($envioCorreo["bExito"] == true ){
                            $respuesta["nCodigo"] = 0;
                            $respuesta["sMensaje"] = "Autorizado y enviado por correo";
                        }else{
                            $respuesta["nCodigo"] = 1;
                            $respuesta["sMensaje"] = "No envio correos";
                        }
                    }else{
                        $respuesta["nCodigo"] = 1;
                        $respuesta["sMensaje"] = "No hay correos";
                    }                        
                }else{
                    $respuesta["nCodigo"] = 1;
                    $respuesta["sMensaje"] = "Fallo al generar los archivos";
                }
            }
        }else{
            $contador = 1;
            $razon ="";
            $sMensajeError .= "<b>NO ES POSIBLE AUTORIZAR EL CORTE:</b><br><br>";
            foreach($rechazo AS $razon){
                $sMensajeError .= $contador.". ".$razon.".<br/>";
                $contador++;
            }
            $respuesta["nCodigo"] = 1;
            $respuesta["sMensaje"] = $sMensajeError;
        }
        echo json_encode($respuesta);
    	
        break;

    case 9:
        $proveedor = $_POST["proveedor"];
        $fechaPago = $_POST["fechaPago"];
        $zona = $_POST["zona"];
        $bError=false;
        $rechazo = array();
        $fecha = date("Y-m-d");

        //valida que los cortes esten en estatus de cerrado => distinto de estatus 1
        $query = "CALL `redefectiva`.`sp_getEstatusCorte`(1,0,$proveedor,$zona,'$fechaPago',1);";
        $resultado = $oRdb->query($query);
        $num=0;
        $resp = mysqli_fetch_row($resultado);
        $num=$resp[0];
                
        if($num > 0){
            $bError=true;
            $rechazo[]="ALGUN CORTE NO CERRADO";
        }

        //valida que los cortes no esten autorizados => en estatus 3
        $query = "CALL `redefectiva`.`sp_getEstatusCorte`(1,0,$proveedor,$zona,'$fechaPago',3);";
        $resultado = $oRdb->query($query);
        $num=0;
        $resp = mysqli_fetch_row($resultado);
        $num=$resp[0];
        
        if($num > 0){
            $bError=true;
            $rechazo[]="ALGUN CORTE ESTA AUTORIZADO";
        }

        //valida que los cortes no esten previamente rechazados=> en estatus 4
        $query = "CALL `redefectiva`.`sp_getEstatusCorte`(1,0,$proveedor,$zona,'$fechaPago',4);";
        $resultado = $oRdb->query($query);
        $num=0;
        $resp = mysqli_fetch_row($resultado);
        $num = $resp[0];
        
        if($num > 0){
            $bError=true;
            $rechazo[]="ALGUN CORTE YA FUE RECHAZADO";
        }

        if(!$bError){           
            $query = "CALL `redefectiva`.`sp_update_corte_proveedor`(1,0,$proveedor,$zona,'$fecha','$fechaPago',4);";
            $resultado = $oWdb->query($query);
            while ($row = mysqli_fetch_assoc($resultado)) { 
                $respuesta["nCodigo"] = $row["estatus"];
                $respuesta["sMensaje"] = $row["mensaje"];                
            }           
            
        }else{
            $contador = 1;
            $razon ="";
            $sMensajeError .= "<b>NO ES POSIBLE RECHAZAR EL CORTE:</b><br><br>";
            foreach($rechazo AS $razon){
                $sMensajeError .= $contador.". ".$razon.".<br/>";
                $contador++;
            }
            $respuesta["nCodigo"] = 1;
            $respuesta["sMensaje"] = $sMensajeError;
        }
        
        echo json_encode($respuesta);
        break;

    case 10:
    	$idsOperacion = $_POST["idsOperacion"];
    	$motivo = $_POST["motivo"];
    	$query = "CALL `redefectiva`.`sp_update_aclaracion`($idsOperacion,'$motivo');";
    	$resultado = $oWdb->query($query);
    	$mensaje="";
    	$estatus ="";
    	while($row = mysqli_fetch_assoc($resultado)){
    		$mensaje = $row["mensaje"];
    		$estatus = $row["estatus"];
    	}
    	echo json_encode(array(
    		"mensaje" => $mensaje,
    		"estatus" => $estatus
    	));
        break;

    case 11:
        $netoDepositado = 0;
    	/************************************DIAS DE LIQUIDACION********************************/        
        $fechaPago    = !empty($_POST["fechaPago"]) ? ($_POST["fechaPago"]) : date();
        $idProveedor = (!empty($_POST["idProveedor"]))? $_POST["idProveedor"] : -1;
        $zona = (!empty($_POST["zona"]))? $_POST["zona"] : 0;
        
        $array_params = array(
            array('name' => 'p_idProveedor',    'value' => $idProveedor,   'type' => 'i'),
            array('name' => 'p_fecha',          'value' => $fechaPago,     'type' => 's'),
            array('name' => 'p_zona',           'value' => $zona,          'type' => 'i')
        );

        $oRdb->setSDatabase('redefectiva');
        $oRdb->setSStoredProcedure('sp_select_reporte_liquidacion');
        $oRdb->setParams($array_params);
        $result = $oRdb->execute();
        $data = $oRdb->fetchAll();
        $opeCobranza = 0;
        $montoCobranza = 0;
        $totOpe =0;
        $totCom =0;
        if ( $result['nCodigo'] ==0){
            $datos = array();
            $index = 0;
            for($i=0;$i<count($data);$i++){
                $opeCobranza = $data[$i]["nTotalOperaciones"];
                $montoCobranza = $data[$i]["nTotalMonto"];
                $totOpe = $totOpe + $data[$i]["nTotalOperaciones"];
                $totCom = $totCom + $data[$i]["nTotalComision"];
                $idCorte = $data[$i]["nIdCorte"];

                $query = "CALL `redefectiva`.`sp_select_aclaraciones_por_corte`($idProveedor,$idCorte);";
                $resultado = $oRdb->query($query);
                while ($row = mysqli_fetch_assoc($resultado)) { 
                    if($row["nIdTipoAclaracion"]==0){ //se quitaron del corte => hay que sumarla
                        $opeCobranza = $opeCobranza + $row["nContador"];
                        $montoCobranza = $montoCobranza + $row["nMonto"];
                    }else{
                        $opeCobranza = $opeCobranza - $row["nContador"];
                        $montoCobranza = $montoCobranza - $row["nMonto"];
                    }//se sumaron del corte => hay que restarle
                }

                $datos[$index]["nIdCorte"] = $idCorte;
                $datos[$index]["nIdEstatus"] = $data[$i]["nIdEstatus"];
                $datos[$index]["nIdProveedor"] = $data[$i]["nIdProveedor"];
                $datos[$index]["nTotalOpeCobranza"] = $opeCobranza;
                $datos[$index]["nTotalOpeLiquidacion"] = $data[$i]["nTotalOperaciones"];
                $datos[$index]["nTotalMontoCobranza"] = "$".number_format($montoCobranza,2,'.',',');
                $datos[$index]["nTotalMontoLiquidacion"] = "$".number_format($data[$i]["nTotalMonto"],2,'.',',');
                $datos[$index]["dFechaCorte"] = $data[$i]["dFechaCorte"];
                $datos[$index]["dFechaPago"] = $data[$i]["dFechaPago"];
                $datos[$index]["diaCorte"] = $data[$i]["diaCorte"];
                $datos[$index]["diaPago"] = $data[$i]["diaPago"];
                $netoDepositado = $netoDepositado + $montoCobranza;
                $index++;
            }
            $oRdb->closeStmt();
            $totalDatos = $oRdb->foundRows();
            $oRdb->closeStmt();
        }else{
            $datos = 0;
            $totalDatos = 0;
        }

        /************************************TOTALES******************************************/
        $comisionProveedor = 0;
        //esta comision se esta dejando en cero porque a telmex no se le retenie comision   
        /*$queryComision = "CALL `redefectiva`.`sp_getComisionProveedor`($idProveedor);";
        $resultadoComision = $oRdb->query($queryComision);

        while($rowComision = mysqli_fetch_assoc($resultadoComision)){
            $comisionProveedor = $rowComision["totComOperacion"];
        }*/

        
        $montoAclaracionesPositivas = 0;
        $montoAclaracionesNegativas = 0;
        $operacionesPositivas = 0;
        $operacionesNegativas = 0;
        
        $oRdb->setSDatabase('redefectiva');
        $array_params = array(
            array('name' => 'p_idProveedor',    'value' => $idProveedor,    'type' => 'i'),
            array('name' => 'p_fecha',          'value' => $fechaPago,      'type' => 's'),
            array('name' => 'p_start',          'value' => 0,               'type' => 'i'),
            array('name' => 'p_limit',          'value' => -1,              'type' => 'i'),
            array('name' => 'p_buscar',         'value' => '',              'type' => 's'),
        );
        
        $oRdb->setSStoredProcedure('sp_getAclaraciones_Tarea');
        $oRdb->setParams($array_params);
        $result = $oRdb->execute();
        $data = $oRdb->fetchAll();
        $datos2 = array();
        $array_cortes = array();
        if ( $result['nCodigo'] ==0){
            $index = 0;
            $numAclaraciones = count($data);
            for($i=0;$i<$numAclaraciones;$i++){
                if($data[$i]["nIdTipoAclaracion"]==0){ //resta =>se quitaron del corte
                    $montoAclaracionesNegativas = $montoAclaracionesNegativas + $data[$i]["nMonto"];
                    $operacionesNegativas++;
                }
                else{//suma =>se sumaron del corte
                    $montoAclaracionesPositivas = $montoAclaracionesPositivas + $data[$i]["nMonto"];
                    $operacionesPositivas++;
                }                
                $index++;
            }
            $comision = $comisionProveedor * $totOpe;   
            if($idProveedor == $GASNATURAL || $idProveedor ==$METROGAS){//para gas natural
                $comision = $totCom;
            }           
            $netoDepositado = $netoDepositado + $montoAclaracionesPositivas - $montoAclaracionesNegativas - $comision;

            $datos2[0]["aclaracionesPositivas"] = $operacionesPositivas;
            $datos2[0]["aclaracionesNegativas"] = $operacionesNegativas;
            $datos2[0]["montoAclaracionesNegativas"] = "$".number_format($montoAclaracionesNegativas,2,".",",");
            $datos2[0]["montoAclaracionesPositivas"] = "$".number_format($montoAclaracionesPositivas,2,".",",");
            $datos2[0]["comision"] = "$".number_format($comision,2,".",",");
            $datos2[0]["netoDepositado"] = "$".number_format($netoDepositado,2,".",",");

            $oRdb->closeStmt();
            $totalDatos = $oRdb->foundRows();
            $oRdb->closeStmt();  
        }
        
        //verifica si estos cortes ya fueron enviadoas
        $query = "CALL `redefectiva`.`sp_select_historial_envios`($idProveedor,$zona,'$fechaPago');";
        $resultadohist = $oRdb->query($query);
        
        $banderaHistorico=1;
        while($rowHist = mysqli_fetch_assoc($resultadohist)){
            $banderaHistorico=0;
        }
        
        $resultado = array(
            "datosCuerpo"        => $datos,
            "datosPie"        => $datos2,
            "historico"         => $banderaHistorico
        );

        echo json_encode($resultado);
        break;
   
    case 12: 
        $corte = 0;
        $proveedor = $_POST["proveedor"];
        $zona = 0;
        $fecha = $_POST["fechaIni"];

        $query = "CALL `redefectiva`.`sp_update_corte_proveedor`(2,$corte,$proveedor,$zona,'$fecha',NULL,2);";
        $resultado = $oWdb->query($query);
        $respuesta="";
        $estatus="";
        while ($row = mysqli_fetch_assoc($resultado)) { 
            $respuesta = $row["mensaje"];
            $estatus = $row["estatus"];
        }
        echo json_encode(array(
            "Mensaje"   => $respuesta,
            "Estatus"   => $estatus
        ));
        break;

    case 13:
        $proveedor = $_POST["proveedor"];
        $fechaPago = $_POST["fechaIni"];
        $zona = 0;
        $bError=false;
        $rechazo = array();
        $fecha = date("Y-m-d");

        //valida que los cortes esten en estatus de cerrado => distinto de estatus 1
        $query = "CALL `redefectiva`.`sp_getEstatusCorte`(1,0,$proveedor,$zona,'$fechaPago',1);";
        $resultado = $oRdb->query($query);
        $num=0;
        $resp = mysqli_fetch_row($resultado);
        $num=$resp[0];
                
        if($num > 0){
            $bError=true;
            $rechazo[]="ALGUN CORTE NO CERRADO";
        }

        //valida que los cortes no esten rechazados => en estatus 4
        $query = "CALL `redefectiva`.`sp_getEstatusCorte`(1,0,$proveedor,$zona,'$fechaPago',4);";
        $resultado = $oRdb->query($query);
        $num=0;
        $resp = mysqli_fetch_row($resultado);
        $num=$resp[0];
        
        if($num > 0){
            $bError=true;
            $rechazo[]="ALGUN CORTE ESTA RECHAZADO";
        }

        if(!$bError){
            //sp_select_liquidacion_proveedor
            $query1 ="CALL `redefectiva`.`sp_select_liquidacion_proveedor`($proveedor,'$fechaPago','$fechaPago',0,-1,'');";
            $resultado1 = $oRdb->query($query1);
            
            while ($row = mysqli_fetch_assoc($resultado1)){               
                $zona= $row["nZona"]; 
                $envioMail = $row["envioCorreo"];               
                $query = "CALL `redefectiva`.`sp_update_corte_proveedor`(1,0,$proveedor,$zona,'$fecha','$fechaPago',3);";
                $resultado = $oWdb->query($query);

                if($envioMail==0){// generar archivos y enviar por correo
                    $oGeneraExcelTelmex = new RE_GeneraExcelTelmex();//aplica para gas natural y telmex
                    $oGeneraExcelTelmex->setNIdProveedor($proveedor);
                    $oGeneraExcelTelmex->setNIdZona($zona);
                    $oGeneraExcelTelmex->setDFechaPago($fechaPago);
                    $oGeneraExcelTelmex->setORdb($oRdb);
                    $oGeneraExcelTelmex->setOWdb($oWdb);
                    $oGeneraExcelTelmex->setOLog($LOG); 
                    $respuestaExcel = $oGeneraExcelTelmex->generaExcel();
                        
                    $oGeneraTxtTelmex = new RE_GeneraTxtTelmex();//aplica para gas natural y telmex
                    $oGeneraTxtTelmex->setNIdProveedor($proveedor);
                    $oGeneraTxtTelmex->setNIdZona($zona);
                    $oGeneraTxtTelmex->setDFechaPago($fechaPago);
                    $oGeneraTxtTelmex->setORdb($oRdb);
                    $oGeneraTxtTelmex->setOWdb($oWdb);
                    $oGeneraTxtTelmex->setOLog($LOG); 
                    $respuestaTxt = $oGeneraTxtTelmex->generaTxt();                

                    if($respuestaExcel['retorno'] == 0 && $respuestaTxt['retorno'] == 0){
                        $dir=$_SERVER['DOCUMENT_ROOT']."/STORAGE/RED_EFECTIVA/TELMEX/";
                        $ruta_archivo_excel = $respuestaExcel['ruta_archivo'];
                        $nombre_archivo_excel = $respuestaExcel['nombre_archivo'];
                        $ruta_archivo_txt = $respuestaTxt['ruta_archivo'];
                        $nombre_archivo_txt = $respuestaTxt['nombre_archivo'];

                        //genera el zip de los archivos
                        $zip = new ZipArchive();
                        $nameZip = "RCGN_".$proveedor."_".$zona."_".$fechaPago.".zip";
                        if ($zip->open($dir.$nameZip, ZipArchive::CREATE)!==TRUE) {
                            $mensaje = "Error al generar el archivo comprimido";
                            $estatus = 1;
                        }else{
                            $zip->addFile($ruta_archivo_excel,$nombre_archivo_excel);
                            $zip->addFile($ruta_archivo_txt,$nombre_archivo_txt);
                            $zip->close();
                        }
                    
                        //envia email correos
                        $correosRespuesta = getListaCorreos($proveedor,$oRdb);
                        if($correosRespuesta["estatus"] ==0 ){
                            $correos = $correosRespuesta["mensaje"];
                            $envioCorreo = envio_correo($dir.$nameZip,$correos);
                            if($envioCorreo["bExito"] == true ){
                                $query = "CALL `redefectiva`.`sp_insert_historial_envios`($proveedor,$zona,'$fechaPago');";
                                $resultado = $oWdb->query($query);
                                
                                $respuesta["nCodigo"] = 0;
                                $respuesta["sMensaje"] = "Autorizado y enviado por correo";
                            }else{
                                $respuesta["nCodigo"] = 1;
                                $respuesta["sMensaje"] = "No envio correos";
                            }
                        }else{
                            $respuesta["nCodigo"] = 1;
                            $respuesta["sMensaje"] = "No hay correos";
                        }                        
                    }else{
                        $respuesta["nCodigo"] = 1;
                        $respuesta["sMensaje"] = "Fallo al generar los archivos";
                    }
                }
                $respuesta["nCodigo"] = 0;
                $respuesta["sMensaje"] = "Correos Enviados";
            }            
        }else{
            $contador = 1;
            $razon ="";
            $sMensajeError .= "<b>NO ES POSIBLE AUTORIZAR EL CORTE:</b><br><br>";
            foreach($rechazo AS $razon){
                $sMensajeError .= $contador.". ".$razon.".<br/>";
                $contador++;
            }
            $respuesta["nCodigo"] = 1;
            $respuesta["sMensaje"] = $sMensajeError;
        }
        echo json_encode($respuesta);
        break;
    default:
		# code...
		break;
}


?>