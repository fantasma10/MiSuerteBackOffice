<?php
class RE_GeneraExcelTelmex{
	//public $nIdProveedor;
	// public $dFechaPago;
	//public $nIdZona;
		
	public function setOWdb($oWdb){
		$this->oWdb = $oWdb;
	}

	public function getOWdb(){
		return $this->oWdb;
	}

	public function setORdb($oRdb){
		$this->oRdb = $oRdb;
	}

	public function getORdb(){
		return $this->oRdb;
	}

	public function setOLog($value){
		$this->oLog = $value;
	}

	public function getOLog(){
		return $this->oLog;
	}

	public function setNIdProveedor($value){
		$this->nIdProveedor = $value;
	}

	public function getNIdProveedor(){
		return $this->nIdProveedor;
	}

	public function setNIdZona($value){
		$this->nIdZona = $value;
	}

	public function getNIdZona(){
		return $this->nIdZona;
	}

	public function setDFechaPago($value){
		$this->dFechaPago = $value;
	}

	public function getDFechaPago(){
		return $this->dFechaPago;
	}

	# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
	public function generaExcel(){
		$objPHPExcel = new PHPExcel();
    	$objPHPExcel->setActiveSheetIndex(0);

    	$month = date('m');
	    $retorno="";
	    $METROGAS = 119;
		$GASNATURAL=27;

	    if($month =="01"){ $retorno= "ENERO";     }
	    if($month =="02"){ $retorno= "FEBRERO";   }
	    if($month =="03"){ $retorno= "MARZO";     }
	    if($month =="04"){ $retorno= "ABRIL";     }
	    if($month =="05"){ $retorno= "MAYO";      } 
	    if($month =="06"){ $retorno= "JUNIO";     }
	    if($month =="07"){ $retorno= "JULIO";     }
	    if($month =="08"){ $retorno= "AGOSTO";    }
	    if($month =="09"){ $retorno= "SEPTIEMBRE";}
	    if($month =="10"){ $retorno= "OCTUBRE";   }
	    if($month =="11"){ $retorno= "NOVIEMBRE"; }
	    if($month =="12"){ $retorno= "DICIEMBRE"; }
	    
	    $fechaPago   = $this->dFechaPago;
        $idProveedor = $this->nIdProveedor;
        $idZona = $this->nIdZona;
        
        if($idProveedor==$GASNATURAL || $idProveedor==$METROGAS){
        	$nombreProveedor="GAS NATURAL MEXICO, S.A. DE C.V.";
        	$dirProveedor ="Horacio No. 1750, Colonia Los Morales Polanco.";
        	$ciudadProveedor ="México D.F.";
        	$descZona="Zona ".$idZona;
        }else{
        	$nombreProveedor="Teléfonos de México, S.A.B. de C.V.";
        	$dirProveedor ="Parque Vía No. 198 Piso 11 ala Oriente.";
        	$ciudadProveedor ="México D.F.";
        	$descZona="";
        }

	    $imgLogo = imagecreatefromjpeg('logo.jpg');
	    $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
	    $objDrawing->setName('Red Efectiva');
	    $objDrawing->setDescription('Red Efectiva');
	    $objDrawing->setImageResource($imgLogo);
	    $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
	    $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
	    $objDrawing->setHeight(50);
	    $objDrawing->setCoordinates('A3');
	    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

	    $rowCount = 1;
	   	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
	    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
	    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
	    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
	    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
	    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);

    	$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, "REPORTE DE COBRANZA");
    	$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    	$rowCount = $rowCount +6;

    	$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $nombreProveedor);
	    $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	    $rowCount++;

	    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, "Gerencia de Cobranza Delegada.");
	    $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	    $rowCount++;

	    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $dirProveedor);
	    $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	    $rowCount++;

	    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $ciudadProveedor);
	    $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	    $rowCount++;

	    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, "Presente:");
	    $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	    $rowCount++;

	    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, "Por este medio le informo el importe liquidado");
	    $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	    $rowCount++;

	    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, "en el periodo correspondiente a la cobranza recaudada");
	    $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	    $rowCount++;

	    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, "en el mes de ".$retorno." los cuales a continuación se integran :");
	    $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

	    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $descZona);
	    $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	    $rowCount = $rowCount+2;

	    //ENCABEZADOS
	    //$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, "DIA DE COBRANZA");
	    //$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	    $objPHPExcel->getActiveSheet()->mergeCells('A'.$rowCount.':C'.$rowCount);
	    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, "COBRANZA");
	    $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':C'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	    $objPHPExcel->getActiveSheet()->mergeCells('D'.$rowCount.':F'.$rowCount);
	    $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, "LIQUIDACION");
	    $objPHPExcel->getActiveSheet()->getStyle('D'.$rowCount.':F'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	    $rowCount++;

	    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, "DIA");
	    $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, "RECIBOS");
	    $objPHPExcel->getActiveSheet()->getStyle('B'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, "IMPORTE");
	    $objPHPExcel->getActiveSheet()->getStyle('C'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	    $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, "DIA");
	    $objPHPExcel->getActiveSheet()->getStyle('D'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	    $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, "RECIBOS");
	    $objPHPExcel->getActiveSheet()->getStyle('E'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, "IMPORTE");
	    $objPHPExcel->getActiveSheet()->getStyle('F'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    	
    	//DIAS DE COBRANZA
    	$rowCount++;
    	$netoDepositado=0;
    	        
        $array_params = array(
            array('name' => 'p_idProveedor',    'value' => $idProveedor,   'type' => 'i'),
            array('name' => 'p_fecha',          'value' => $fechaPago,     'type' => 's'),
            array('name' => 'p_zona',          	'value' => $idZona,     'type' => 'i')
        );

        $this->oRdb->setSDatabase('redefectiva');
        $this->oRdb->setSStoredProcedure('sp_select_reporte_liquidacion');
        $this->oRdb->setParams($array_params);
        $result = $this->oRdb->execute();
        $data = $this->oRdb->fetchAll();

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
                $resultado = $this->oRdb->query($query);
                while ($row = mysqli_fetch_assoc($resultado)) { 
                    if($row["nIdTipoAclaracion"]==0){ //se quitaron del corte => hay que sumarla
                        $opeCobranza = $opeCobranza + $row["nContador"];
                        $montoCobranza = $montoCobranza + $row["nMonto"];
                    }else{
                        $opeCobranza = $opeCobranza - $row["nContador"];
                        $montoCobranza = $montoCobranza - $row["nMonto"];
                    }//se sumaron del corte => hay que restarle
                }

            	$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $data[$i]["diaCorte"]);
            	$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            	
            	$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $opeCobranza);
            	$objPHPExcel->getActiveSheet()->getStyle('B'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            	
            	$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, "$".number_format($montoCobranza,2,'.',','));
            	$objPHPExcel->getActiveSheet()->getStyle('C'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            	
            	$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount,  $data[$i]["diaPago"]);
            	$objPHPExcel->getActiveSheet()->getStyle('D'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            	
            	$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $data[$i]["nTotalOperaciones"]);
            	$objPHPExcel->getActiveSheet()->getStyle('E'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            	
            	$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, "$".number_format($data[$i]["nTotalMonto"],2,'.',','));
            	$objPHPExcel->getActiveSheet()->getStyle('F'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                
                $netoDepositado = $netoDepositado + $montoCobranza;
                $rowCount++;
            }
            $this->oRdb->closeStmt();
            $totalDatos = $this->oRdb->foundRows();
            $this->oRdb->closeStmt();
        }

        /************************************TOTALES******************************************/
        $comisionProveedor = 0;
        //esta comision se esta dejando en cero porque a telmex no se le retenie comision 
        /*$queryComision = "CALL `redefectiva`.`sp_getComisionProveedor`($idProveedor);";
        $resultadoComision = $this->oRdb->query($queryComision);

        while($rowComision = mysqli_fetch_assoc($resultadoComision)){
            $comisionProveedor = $rowComision["totComOperacion"];
        }*/

        $montoAclaracionesPositivas = 0;
        $montoAclaracionesNegativas = 0;
        $operacionesPositivas = 0;
        $operacionesNegativas = 0;
        
        $this->oRdb->setSDatabase('redefectiva');
        $array_params = array(
            array('name' => 'p_idProveedor',    'value' => $idProveedor,    'type' => 'i'),
            array('name' => 'p_fecha',          'value' => $fechaPago,      'type' => 's'),
            array('name' => 'p_start',          'value' => 0,               'type' => 'i'),
            array('name' => 'p_limit',          'value' => -1,              'type' => 'i'),
            array('name' => 'p_buscar',         'value' => '',              'type' => 's'),
        );

        $this->oRdb->setSStoredProcedure('sp_getAclaraciones_Tarea');
        $this->oRdb->setParams($array_params);
        $result = $this->oRdb->execute();
        $data = $this->oRdb->fetchAll();
        
        if ($result['nCodigo'] == 0){
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
            
            $this->oRdb->closeStmt();
            $totalDatos = $this->oRdb->foundRows();
            $this->oRdb->closeStmt();

            //ACLARACIONES POSITVAS
            if($operacionesPositivas>0){
			    $objPHPExcel->getActiveSheet()->mergeCells('A'.$rowCount.':E'.$rowCount);
			    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, "+ ".$operacionesPositivas." ACLARACIONES");
			    $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':E'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, "$".number_format($montoAclaracionesPositivas,2,'.',','));
			    $objPHPExcel->getActiveSheet()->getStyle('F'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			    $rowCount++;
			}

			//ACLARACIONES NEGATIVAS
            if($operacionesNegativas>0){
			    $objPHPExcel->getActiveSheet()->mergeCells('A'.$rowCount.':E'.$rowCount);
			    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, "- ".$operacionesNegativas." ACLARACIONES");
			    $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':E'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, "$".number_format($montoAclaracionesNegativas,2,'.',','));
			    $objPHPExcel->getActiveSheet()->getStyle('F'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			    $rowCount++;
			}

			//COMISION
            $objPHPExcel->getActiveSheet()->mergeCells('A'.$rowCount.':E'.$rowCount);
		    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, "- COMISION");
		    $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':E'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, "$".number_format($comision,2,'.',','));
		    $objPHPExcel->getActiveSheet()->getStyle('F'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		    $rowCount++;

		    //NETO DEPOSITADO
            $objPHPExcel->getActiveSheet()->mergeCells('A'.$rowCount.':E'.$rowCount);
		    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, "NETO DEPOSITADO");
		    $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':E'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, "$".number_format($netoDepositado,2,'.',','));
		    $objPHPExcel->getActiveSheet()->getStyle('F'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }
    	
    	$styleArray = array(
			"borders" => array(
				"allborders" => array(
					"style" => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);

		$objPHPExcel->getActiveSheet()->getStyle('A16:F'.$rowCount)->applyFromArray($styleArray);
		unset($styleArray);

    	//GUARDAR EL ARCHIVO
	    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	    if($idZona==0){
	    	$nombreArchivoExcel =$this->nIdProveedor."_".$this->dFechaPago;
	    }else{
	    	$nombreArchivoExcel =$this->nIdProveedor."_".$idZona."_".$this->dFechaPago;
	    }
	    
	    $dir=$_SERVER['DOCUMENT_ROOT']."/STORAGE/RED_EFECTIVA/TELMEX/";

	   	if(!is_dir($dir)){
	    	mkdir($dir, '0777', true);
	    }

	    $a=$objWriter->save($dir.$nombreArchivoExcel.'.xlsx');
	    
	    if (file_exists($dir.$nombreArchivoExcel.'.xlsx')) 
	    	$arrayRespuesta["retorno"] = 0;
	    else
	    	$arrayRespuesta["retorno"] = 1;

	    $arrayRespuesta["ruta_archivo"] = $dir.$nombreArchivoExcel.'.xlsx';
	    $arrayRespuesta["nombre_archivo"] = $nombreArchivoExcel.'.xlsx';
    	return $arrayRespuesta;
	}
}
?>