<?php

class Poliza{

	public $nIdPoliza;
	public $oHeader;
	public $arrayMovimientos;
	public $sListaMovimientos;
	public $oRdb;
	public $oWdb;
	public $bMismoDia;
	public $nIdUsuario;
	public $oPhpExcel;
	public $oPolizaMovimiento;
	public $nNumCuentaContableBanco;

	public function setNNumCuentaContableBanco($value) {
		$this->nNumCuentaContableBanco = $value;
	}

	public function getNNumCuentaContableBanco() {
		return $this->nNumCuentaContableBanco;
	}

	public function setOPolizaMovimiento($value) {
		$this->oPolizaMovimiento = $value;
	}

	public function getOPolizaMovimiento() {
		return $this->oPolizaMovimiento;
	}

	public function setOPhpExcel($value) {
		$this->oPhpExcel = $value;
	}

	public function getOPhpExcel() {
		return $this->oPhpExcel;
	}

	public function setNIdUsuario($value) {
		$this->nIdUsuario = $value;
	}

	public function getNIdUsuario() {
		return $this->nIdUsuario;
	}

	public function setNIdPoliza($nIdPoliza){
		$this->nIdPoliza = $nIdPoliza;
	}

	public function getNIdPoliza(){
		return $this->nIdPoliza;
	}

	public function setBMismoDia($bMismoDia){
		$this->bMismoDia = $bMismoDia;
	}

	public function getBMismoDia(){
		return $this->bMismoDia;
	}

	public function setOHeader($oHeader){
		$this->oHeader = $oHeader;
	}

	public function getOHeader(){
		return $this->oHeader;
	}

	public function setArrayMovimientos($arrayMovimientos){
		$this->arrayMovimientos = $arrayMovimientos;
	}

	public function getArrayMovimientos(){
		return $this->arrayMovimientos;
	}

	public function setORdb($value){
		$this->oRdb = $value;
	}

	public function getORdb(){
		return $this->oRdb;
	}

	public function setOWdb($value){
		$this->oWdb = $value;
	}

	public function getOWdb(){
		return $this->oWdb;
	}

	public function setSListaMovimientos($sLista){
		$this->sListaMovimientos = $sLista;
	}

	public function getSListaMovimientos(){
		return $this->sListaMovimientos;
	}

	# # # # # # # # # # # # # # # # # # # # # # # #

	public function verificaBandera(){
		$array_params = array();

		$this->oWdb->setSDatabase('redefectiva');
		$this->oWdb->setSStoredProcedure('sp_select_poliza_bandera');
		$this->oWdb->setParams($array_params);

		$result = $this->oWdb->execute();

		if($result['bExito'] == false || $result['nCodigo'] != 0){
			return $result;
		}

		$data = $this->oWdb->fetchAll();

		$this->oWdb->closeStmt();

		return array(
			'bExito'	=> true,
			'nCodigo'	=> 0,
			'sMensaje'	=> 'Consulta Ok',
			'data'		=> $data
		);
	} # verificaBandera

	public function liberaBandera(){
		$array_params = array(
			array(
				'name'	=> 'bPolizaBandera',
				'value'	=> 0,
				'type'	=> 'i'
			)
		);

		$this->oWdb->setSDatabase('redefectiva');
		$this->oWdb->setSStoredProcedure('sp_update_poliza_bandera');
		$this->oWdb->setParams($array_params);

		$result = $this->oWdb->execute();

		if($result['bExito'] == false || $result['nCodigo'] != 0){
			return $result;
		}

		$this->oWdb->closeStmt();

		return array(
			'bExito'	=> true,
			'nCodigo'	=> 0,
			'sMensaje'	=> 'Consulta Ok'
		);
	} # liberaBandera

	public function buscaDatosPolizaIngresos(){
		$array_params = array(
			array(
				'name'	=> 'sListaMovimientos',
				'value'	=> self::getSListaMovimientos(),
				'type'	=> 's'
			),
			array(
				'name'	=> 'bMismoDia',
				'type'	=> 'i',
				'value'	=> self::getBMismoDia()
			)
		);

		$this->oWdb->setSDatabase('redefectiva');
		$this->oWdb->setSStoredProcedure('SP_SELECT_MOVSPOLIZAINGRESOS');
		$this->oWdb->setParams($array_params);
		$resultado = $this->oWdb->execute();

		if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
			return $resultado;
		}

		$array_lista = $this->oWdb->fetchAll();

		$arrayMovimientos	= array();
		$nIdMovPoliza		= 1;

		$arrayMovimientos	= array();

		foreach($array_lista AS $mov){
			# armar registro corresponsal
			$nIdUsuario = self::getNIdUsuario();

			$oPolizaMovimiento	= new PolizaMovimiento();
			$oPolizaMovimiento->setOWdb($this->oWdb);
			$oPolizaMovimiento->setNIdUsuario($nIdUsuario);
			$oPolizaMovimiento->setNIdMovPoliza($nIdMovPoliza);

			foreach($mov AS $key => $value){
				if(property_exists('PolizaMovimiento', $key)){
					$oPolizaMovimiento->{$key} = $value;
				}
			}

			$arrayMovimientos[] = $oPolizaMovimiento;

			# armar registro banco
			$nIdMovPoliza+=1;
			$oPolizaMovimiento2	= new PolizaMovimiento();
			$oPolizaMovimiento2->setOWdb($this->oWdb);
			$oPolizaMovimiento2->setNIdUsuario($nIdUsuario);
			$oPolizaMovimiento2->setNIdMovPoliza($nIdMovPoliza);

			foreach($mov AS $key => $value){
				if(property_exists('PolizaMovimiento', $key)){
					$oPolizaMovimiento2->{$key} = $value;
				}
			}

			$oPolizaMovimiento2->setNIdMovPoliza($nIdMovPoliza);
			$oPolizaMovimiento2->setSCAmpo1($mov['nNumCuentaContableBanco']);
			$oPolizaMovimiento2->setSCampo3(0);

			$arrayMovimientos[] = $oPolizaMovimiento2;

			$nIdMovPoliza+=1;
		} # foreach

		self::setArrayMovimientos($arrayMovimientos);

		$this->oWdb->closeStmt();

		return array(
			'bExito'	=> true,
			'nCodigo'	=> 0,
			'sMensaje'	=> 'Consulta Ok'
		);
	} # buscaDAtosPolizaIngresos

	public function buscaDatosPolizaDepositosNoIdentificados(){
		$array_params = array(
			array(
				'name'	=> 'sListaMovimientos',
				'type'	=> 's',
				'value'	=> self::getSListaMovimientos()
			),
			array(
				'name'	=> 'nNumCuentaContableBanco',
				'type'	=> 's',
				'value'	=> self::getNNumCuentaContableBanco()
			)
		);

		$this->oWdb->setBDebug(1);
		$this->oWdb->setSDatabase('redefectiva');
		$this->oWdb->setSStoredProcedure('SP_SELECT_MOVSPOLIZADEPOSITOSNOIDENTIFICADOS');
		$this->oWdb->setParams($array_params);
		$resultado = $this->oWdb->execute();

		if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
			return $resultado;
		}

		$array_lista = $this->oWdb->fetchAll();

		$arrayMovimientos	= array();
		$nIdMovPoliza		= 1;

		$arrayMovimientos	= array();

		foreach($array_lista AS $mov){
			$nIdUsuario = self::getNIdUsuario();

			$oPolizaMovimiento	= new PolizaMovimiento();
			$oPolizaMovimiento->setOWdb($this->oWdb);
			$oPolizaMovimiento->setNIdUsuario($nIdUsuario);
			$oPolizaMovimiento->setNIdMovPoliza($nIdMovPoliza);

			foreach($mov AS $key => $value){
				if(property_exists('PolizaMovimiento', $key)){
					$oPolizaMovimiento->{$key} = $value;
				}
			}

			$arrayMovimientos[] = $oPolizaMovimiento;

			$nIdMovPoliza+=1;
		} # foreach

		self::setArrayMovimientos($arrayMovimientos);

		$this->oWdb->closeStmt();

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> 'Ok',
			'sMensajeDetallado'	=> 'Ok',
			'data'				=> array()
		);
	} # buscaDatosPolizaDepositosNoIdentificados

	public function guardar(){
		$oHeader			= self::getOHeader();
		$arrayMovimientos	= self::getArrayMovimientos();

		$resultado = $oHeader->guardar();

		if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
			return $resultado;
		}

		self::setNIdPoliza($oHeader->getNIdPoliza());

		$cuenta = 0;
		foreach($arrayMovimientos as $oPolizaMovimiento){
			$oPolizaMovimiento->setNIdPoliza(self::getNIdPoliza());
			$resultado = $oPolizaMovimiento->guardar();

			if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
				//echo '<pre>'; var_dump($oPolizaMovimiento); echo '</pre>';
				return $resultado;
			}

			$cuenta++;
		}

		$array_data = array(
			'nIdPoliza'	=> self::getNIdPoliza(),
			'nRegs'		=> $cuenta
		);

		return array(
			'bExito'	=> true,
			'nCodigo'	=> 0,
			'sMensaje'	=> 'Poliza guardada Correctamente',
			'data'		=> $array_data
		);
	} # guardar

	private function _header(){
		$this->oPhpExcel = new PHPExcel();

		$this->oPhpExcel->getDefaultStyle()->getFont()->setName('Calibri');
		$this->oPhpExcel->getDefaultStyle()->getFont()->setSize(10);

		#PHPExcel_Cell::setValueBinder(new PHPExcel_Cell_AdvancedValueBinder());

		$fecha = date('Y-m-d H:i:s');

		$date			= new DateTime($fecha);
		$ExcelDateValue	= PHPExcel_Shared_Date::PHPToExcel($date);

		$this->oPhpExcel->getProperties()->setCreator("Red Efectiva")
		                             ->setCreated($ExcelDateValue)
		                             ->setLastModifiedBy("Red Efectiva")
		                             ->setTitle("Datos")
		                             ->setSubject("Datos")
		                             ->setDescription("Contiene los registros de ....")
		                             ->setKeywords("office PHPExcel php")
		                             ->setCategory("Contabilidad");

		$this->oPhpExcel->getActiveSheet()->setTitle('Datos');
		$this->_sheet = $this->oPhpExcel->setActiveSheetIndex(0);

		$sCeldaInicial	= "A";
		$sCeldaFinal	= "T";
		$nCeldaInicial	= "1";
		$nCeldaFinal	= "10";

		$array = array(
			'A' => array(1,2,3,4,5,6,7,8,9,10),
			'B' => array(1,2,3,4,5,6,7,8,9,10),
			'C' => array(2,3,4,5,6,7,8,9,10),
			'D' => array(3,4,5,7,8,10),
			'E' => array(3,4,5,7,8,10),
			'F' => array(3,4,7,8,10),
			'G' => array(3,4,7,8,10),
			'H' => array(3,4,7,8,10),
			'I' => array(3,4,7,8,10),
			'J' => array(3,7,8,10),
			'K' => array(3,7,8),
			'L' => array(3,7,8),
			'M' => array(3,7,8),
			'N' => array(3,7,8),
			'O' => array(7,8),
			'P' => array(7,8),
			'Q' => array(7,8),
			'R' => array(7,8),
			'S' => array(7,8),
			'T' => array(7,8)
		);

		foreach($array AS $key => $arr){

			foreach ($arr AS $value) {
				$this->_sheet->getStyle($key.$value)
				->getNumberFormat()
				->setFormatCode(
					PHPExcel_Style_NumberFormat::FORMAT_TEXT
				);
			}
		}

		/*for($nCeldaActual=$nCeldaInicial; $nCeldaActual<=$nCeldaFinal;$nCeldaActual++){
			$sColumnaActual = $sCeldaInicial;

			while($sColumnaActual != $sCeldaFinal){
				$this->_sheet->getStyle($sColumnaActual.$nCeldaActual)
					->getNumberFormat()
					->setFormatCode(
						PHPExcel_Style_NumberFormat::FORMAT_TEXT
					);
				$sColumnaActual = chr(ord($sColumnaActual) + 1);
			}
		}*/

		$this->_sheet->setCellValue('A1', 'Causación de IVA (Concepto de IETU)(E)')
		      ->setCellValue('A2', 'Datos para Facturación Electrónica(FE)')
		      ->setCellValue('A3', 'Causación de IVA (IETU)(D)')
		      ->setCellValue('A4', 'Movimiento de póliza(M)')
		      ->setCellValue('A5', 'Devolución de IVA (IETU)(W2)')
		      ->setCellValue('A6', 'Devolución de IVA (IETU)(W)')
		      ->setCellValue('A7', 'Causación de IVA(C)')
		      ->setCellValue('A8', 'Devolución de IVA(V)')
		      ->setCellValue('A9', 'Periodo de causación de IVA(R)')
		      ->setCellValue('A10', 'Póliza(P)')
		      ->setCellValue('B1', 'IdConceptoIETU')
		      ->setCellValue('B2', 'RutaAnexo')
		      ->setCellValue('B3', 'IVATasa15NoAcred')
		      ->setCellValue('B4', 'IdCuenta')
		      ->setCellValue('B5', 'IETUDeducible')
		      ->setCellValue('B6', 'IETUDeducible')
		      ->setCellValue('B7', 'Tipo')
		      ->setCellValue('B8', 'IdProveedor')
		      ->setCellValue('B9', 'EjercicioAsignado')
		      ->setCellValue('B10', 'Fecha')
		      ->setCellValue('C2', 'ArchivoAnexo')
		      ->setCellValue('C3', 'IVATasa10NoAcred')
		      ->setCellValue('C4', 'Referencia')
		      ->setCellValue('C5', 'IETUAcreditable')
		      ->setCellValue('C6', 'IETUModificado')
		      ->setCellValue('C7', 'TotTasa15')
		      ->setCellValue('C8', 'ImpTotal')
		      ->setCellValue('C9', 'PeriodoAsignado')
		      ->setCellValue('C10', 'TipoPol')
		      ->setCellValue('D3', 'IETU')
		      ->setCellValue('D4', 'TipoMovto')
		      ->setCellValue('D5', 'IETUModificado')
		      ->setCellValue('D7', 'BaseTasa15')
		      ->setCellValue('D8', 'PorIVA')
		      ->setCellValue('D10', 'Folio')
		      ->setCellValue('E3', 'Modificado')
		      ->setCellValue('E4', 'Importe')
		      ->setCellValue('E5', 'IdConceptoIETU')
		      ->setCellValue('E7', 'IVATasa15')
		      ->setCellValue('E8', 'ImpBase')
		      ->setCellValue('E10', 'Clase')
		      ->setCellValue('F3', 'Origen')
		      ->setCellValue('F4', 'IdDiario')
		      ->setCellValue('F7', 'TotTasa10')
		      ->setCellValue('F8', 'ImpIVA')
		      ->setCellValue('F10', 'IdDiario')
		      ->setCellValue('G3', 'TotTasa16')
		      ->setCellValue('G4', 'ImporteME')
		      ->setCellValue('G7', 'BaseTasa10')
		      ->setCellValue('G8', 'CausaIVA')
		      ->setCellValue('G10', 'Concepto')
		      ->setCellValue('H3', 'BaseTasa16')
		      ->setCellValue('H4', 'Concepto')
		      ->setCellValue('H7', 'IVATasa10')
		      ->setCellValue('H8', 'ExentoIVA')
		      ->setCellValue('H10', 'SistOrig')
		      ->setCellValue('I3', 'IVATasa16')
		      ->setCellValue('I4', 'IdSegNeg')
		      ->setCellValue('I7', 'TotTasa0')
		      ->setCellValue('I8', 'Serie')
		      ->setCellValue('I10', 'Impresa')
		      ->setCellValue('J3', 'IVATasa16NoAcred')
		      ->setCellValue('J7', 'BaseTasa0')
		      ->setCellValue('J8', 'Folio')
		      ->setCellValue('J10', 'Ajuste')
		      ->setCellValue('K3', 'TotTasa11')
		      ->setCellValue('K7', 'TotTasaExento')
		      ->setCellValue('K8', 'Referencia')
		      ->setCellValue('L3', 'BaseTasa11')
		      ->setCellValue('L7', 'BaseTasaExento')
		      ->setCellValue('L8', 'OtrosImptos')
		      ->setCellValue('M3', 'IVATasa11')
		      ->setCellValue('M7', 'TotOtraTasa')
		      ->setCellValue('M8', 'ImpSinRet')
		      ->setCellValue('N3', 'IVATasa11NoAcred')
		      ->setCellValue('N7', 'BaseOtraTasa')
		      ->setCellValue('N8', 'IVARetenido')
		      ->setCellValue('O7', 'IVAOtraTasa')
		      ->setCellValue('O8', 'ISRRetenido')
		      ->setCellValue('P7', 'ISRRetenido')
		      ->setCellValue('P8', 'GranTotal')
		      ->setCellValue('Q7', 'TotOtros')
		      ->setCellValue('Q8', 'EjercicioAsignado')
		      ->setCellValue('R7', 'IVARetenido')
		      ->setCellValue('R8', 'PeriodoAsignado')
		      ->setCellValue('S7', 'Captado')
		      ->setCellValue('S8', 'IdCuenta')
		      ->setCellValue('T7', 'NoCausar')
		      ->setCellValue('T8', 'IVAPagNoAcred');

		$this->_sheet->getColumnDimension('B')->setWidth('12.29');
		$this->_sheet->getColumnDimension('G')->setWidth('22.86');
		$this->_sheet->getColumnDimension('H')->setWidth('45.29');
	}

	public function generarLayout(){
		$nIdPoliza = self::getNIdPoliza();

		$this->oHeader->setNIdPoliza($nIdPoliza);
		$this->oPolizaMovimiento->setNIdPoliza($nIdPoliza);

		$resultado_header	= $this->oHeader->cargar();
		$resultado_movs		= $this->oPolizaMovimiento->cargar();

		$data_movs		= $resultado_movs['data'];
		$data_header	= $resultado_header['data'];

		self::_header();

		$highestRow	= $this->_sheet->getHighestRow();
		$fila = $highestRow + 1;
		//$fila = 11;

		$array_formato_header = array(
			'A'	=> '@',
			'B'	=> 'yyyymmdd',
			'C'	=> '',
			'D'	=> '',
			'E'	=> '',
			'F'	=> '@',
			'G'	=> '@',
			'H'	=> '',
			'I'	=> '',
			'J'	=> ''
		);

		foreach($data_header AS $registros){
			$columna = 'A';

			foreach($registros as $valor){
				if($array_formato_header[$columna] != ''){
					$formato = $array_formato_header[$columna];
					$this->_sheet->getStyle($columna.$fila)->getNumberFormat()->setFormatCode($formato);
					#$this->_sheet->getStyleByColumnAndRow($columna, $fila)->getNumberFormat()->setFormatCode($formato);
				}

				if($columna === 'B'){
					/*$PHPDateValue	= strtotime($valor.' 00:00:00');
					$newPHPDateValue= date('d/m/Y', $PHPDateValue);
					$ExcelDateValue	= PHPExcel_Shared_Date::PHPToExcel($PHPDateValue);*/

					$date			= new DateTime($valor);
					$ExcelDateValue	= PHPExcel_Shared_Date::PHPToExcel($date);

					#$this->_sheet->setCellValueByColumnAndRow($columna, $fila, $ExcelDateValue);
					$this->_sheet->setCellValue($columna.$fila , $ExcelDateValue);
					$this->_sheet->getStyle($columna.$fila)->getNumberFormat()->setFormatCode($formato);
					#$this->_sheet->getStyleByColumnAndRow($columna, $fila)->getNumberFormat()->setFormatCode($formato);
				}
				else{
					#$this->_sheet->setCellValueByColumnAndRow($columna, $fila, $valor);
					$this->_sheet->setCellValue($columna.$fila , $valor);
				}

				$columna = chr(ord($columna) + 1);

			}

			$fila++;
		}
		//exit();

		$array_formato_movs = array(
			'A'	=> '@',
			'B'	=> '',
			'C'	=> '@',
			'D'	=> '',
			'E'	=> '',
			'F'	=> '@',
			'G'	=> '',
			'H'	=> '',
			'I'	=> '@',
			'J'	=> '',
			'K'	=> '',
			'L'	=> '',
			'M'	=> '',
			'N'	=> '',
			'O'	=> '',
			'P'	=> '',
			'Q'	=> '',
			'R'	=> '',
			'S'	=> '',
			'T'	=> '',
			'U'	=> ''
		);

		foreach($data_movs as $registros){
			$columna = 'A';

			foreach($registros as $valor){
				if($array_formato_movs[$columna] != ''){
					$formato = $array_formato_movs[$columna];

					$this->_sheet->getStyle($columna.$fila)
						->getNumberFormat()
						->setFormatCode($formato);
				}

				$this->_sheet->setCellValue($columna.$fila , $valor);
				$columna = chr(ord($columna) + 1);
			}

			$fila++;
		}

		$nombrexls = 'LAYOUT.xls';

		#header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-type: application/octet-stream");
		//header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: inline;filename="' . $nombrexls . '"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Expires: 0'); // Date in the past
		#header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Last-Modified: '.date('Y-m-d H:i:s')); // always modified
		#header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: no-cache'); // HTTP/1.0*/

		#$oGuardar = PHPExcel_IOFactory::createWriter($this->oPhpExcel, 'Excel2007');
		$oGuardar = PHPExcel_IOFactory::createWriter($this->oPhpExcel, 'Excel5');
		$oGuardar->save('php://output');


		exit();
	} # generarLayout

	public function obtenerListaTbl($array_params){
		$this->oWdb->setBDebug(1);
		$this->oWdb->setSDatabase('redefectiva');
		$this->oWdb->setSStoredProcedure('SP_SELECT_POLIZA_LISTA');
		$this->oWdb->setParams($array_params);
		$resultado = $this->oWdb->execute();

		if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
			return $resultado;
		}

		$data		= $this->oWdb->fetchAll();
		$num_rows	= $this->oWdb->numRows();
		$this->oWdb->closeStmt();

		$found_rows	= $this->oWdb->foundRows();

		$this->oWdb->closeStmt();

		return array(
			'bExito'	=> true,
			'nCodigo'	=> 0,
			'sMensaje'			=> 'Consulta Exitosa',
			'sMensajeDetallado'	=> 'Consulta Exitosa',
			'data'				=> $data,
			'num_rows'			=> $num_rows,
			'found_rows'		=> $found_rows
		);
	} # obtenerListaTbl
} # Poliza
?>