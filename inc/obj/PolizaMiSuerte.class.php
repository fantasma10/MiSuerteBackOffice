<?php

class PolizaMiSuerte{

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
	public $nIdCorte;

	public function setNIdCorte($value){
		$this->nIdCorte = $value;
	}

	public function getNIdCorte(){
		return $this->nIdCorte;
	}

	public function setNNumCuentaContableBanco($value){
		$this->nNumCuentaContableBanco = $value;
	}

	public function getNNumCuentaContableBanco(){
		return $this->nNumCuentaContableBanco;
	}

	public function setOPolizaMovimiento($value){
		$this->oPolizaMovimiento = $value;
	}

	public function getOPolizaMovimiento(){
		return $this->oPolizaMovimiento;
	}

	public function setOPhpExcel($value){
		$this->oPhpExcel = $value;
	}

	public function getOPhpExcel(){
		return $this->oPhpExcel;
	}

	public function setNIdUsuario($value){
		$this->nIdUsuario = $value;
	}

	public function getNIdUsuario(){
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

	public function buscaDatosPolizaIngresos(){
		$array_params = array(
			array(
				'name'	=> 'nIdCorte',
				'value'	=> self::getNIdCorte(),
				'type'	=> 'i'
			)
		);

		$this->oWdb->setSDatabase('pronosticos');
		$this->oWdb->setSStoredProcedure('sp_select_poliza_movimientos');
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

			$oPolizaMovimiento	= new PolizaMovimientoMiSuerte();
			$oPolizaMovimiento->setOWdb($this->oWdb);
			$oPolizaMovimiento->setNIdUsuario($nIdUsuario);
			$oPolizaMovimiento->setNIdMovPoliza($nIdMovPoliza);
			$nIdCorte = self::getNIdCorte();
			$oPolizaMovimiento->setNIdCorte($nIdCorte);

			foreach($mov AS $key => $value){
				if(property_exists('PolizaMovimiento', $key)){
					$oPolizaMovimiento->{$key} = $value;
				}
			}

			$arrayMovimientos[] = $oPolizaMovimiento;
		} # foreach

		self::setArrayMovimientos($arrayMovimientos);

		$this->oRdb->closeStmt();

		if(count($arrayMovimientos) == 0){
			return array(
				'bExito'	=> false,
				'nCodigo'	=> 1,
				'sMensaje'	=> 'No se encontraron Movimientos para la Poliza'
			);
		}

		return array(
			'bExito'	=> true,
			'nCodigo'	=> 0,
			'sMensaje'	=> 'Consulta Ok'
		);
	} # buscaDAtosPolizaIngresos

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

		$this->oPhpExcel->getProperties()->setCreator("mi suerte")
		                             ->setLastModifiedBy("mi suerte")
		                             ->setTitle("Datos")
		                             ->setSubject("Datos")
		                             ->setDescription("Contiene los registros de ....")
		                             ->setKeywords("office PHPExcel php")
		                             ->setCategory("Contabilidad");

		$this->oPhpExcel->getActiveSheet()->setTitle('Datos');
		$this->_sheet = $this->oPhpExcel->setActiveSheetIndex(0);

		$this->_sheet->setCellValue('A1', 'Causación de IVA (Concepto de IETU)(E)')
		      ->setCellValue('A2', 'Datos para Facturación Electrónica(FE) ')
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

		foreach($data_header AS $registros){
			$columna = 'A';

			foreach($registros as $valor){
				$this->_sheet->setCellValue($columna.$fila , $valor);
				$columna = chr(ord($columna) + 1);
			}

			$fila++;
		}

		foreach($data_movs as $registros){
			$columna = 'A';

			foreach($registros as $valor){
				$this->_sheet->setCellValue($columna.$fila , $valor);
				$columna = chr(ord($columna) + 1);
			}

			$fila++;
		}

		$nombrexls = $resultado_header['data'][0]['sFolio'].'.xlsx';

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $nombrexls . '"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0

		$oGuardar = PHPExcel_IOFactory::createWriter($this->oPhpExcel, 'Excel2007');
		$oGuardar->save('php://output');
	} # generarLayout

	public function obtenerListaTbl($array_params){
		$this->oWdb->setBDebug(1);
		$this->oWdb->setSDatabase('pronosticos');
		$this->oWdb->setSStoredProcedure('SP_SELECT_POLIZA_LISTA');
		$this->oWdb->setParams($array_params);
		$resultado = $this->oWdb->execute();

		if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
			return $resultado;
		}

		$data		= $this->oWdb->fetchAll();
		$num_rows	= $this->oWdb->numRows();

		$this->oWdb->closeStmt();

		return array(
			'bExito'	=> true,
			'nCodigo'	=> 0,
			'sMensaje'			=> 'Consulta Exitosa',
			'sMensajeDetallado'	=> 'Consulta Exitosa',
			'data'				=> $data,
			'num_rows'			=> $num_rows
		);
	} # obtenerListaTbl
} # Poliza
?>