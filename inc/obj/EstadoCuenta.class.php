<?php

class EstadoCuenta{

	public $RBD;
	public $WBD;
	public $LOG;

	public $nIdBanco;
	public $dFechaInicial;
	public $dFechaFinal;
	public $nIdUsuario;
	public $nNumCuentaBancaria;
	public $nNumCuentaContable;

	private $_oPhpExcel;
	private $_file;

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

	public function setNIdBanco($nIdBanco){
		$this->nIdBanco = $nIdBanco;
	}

	public function getNIdBanco(){
		return $this->nIdBanco;
	}

	public function setOLog($value){
		$this->oLog = $value;
	}

	public function getOLog(){
		return $this->oLog;
	}

	public function setDFechaInicial($value){
		$this->dFechaInicial = $value;
	}

	public function getDFechaInicial(){
		return $this->dFechaInicial;
	}

	public function setDFechaFinal($value){
		$this->dFechaFinal = $value;
	}

	public function getDFechaFinal(){
		return $this->dFechaFinal;
	}

	public function setNIdUsuario($value){
		$this->nIdUsuario = $value;
	}

	public function getNIdUsuario(){
		return $this->nIdUsuario;
	}

	public function setNNumCuentaBancaria($value){
		$this->nNumCuentaBancaria = $value;
	}

	public function getNNumCuentaBancaria(){
		return $this->nNumCuentaBancaria;
	}

	public function setNNumCuentaContable($value){
		$this->nNumCuentaContable = $value;
	}

	public function getNNumCuentaContable(){
		return $this->nNumCuentaContable;
	}

	public function setOPhpExcel($oPhpExcel){
		$this->_oPhpExcel = $oPhpExcel;
	}

	public function getOPhpExcel(){
		return $this->_oPhpExcel;
	}

	public function setFile($file){
		$this->_file = $file;
	}

	public function getFile(){
		return $this->_file;
	}

	public function setOLayoutEstadoCuenta($oLayoutEstadoCuenta){
		$this->oLayoutEstadoCuenta = $oLayoutEstadoCuenta;
	}

	public function getOLayoutEstadoCuenta(){
		return $this->oLayoutEstadoCuenta;
	}

	private function _getHumanDate($EXCEL_DATE){
		$UNIX_DATE = ($EXCEL_DATE - 25569) * 86400;
		return gmdate("Y-m-d", $UNIX_DATE);
	}

	# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #

	public function cargarMovimientos(){
		$arrRes = self::_initPhpExcel();

		if($arrRes['bExito'] == false){
			return $arrRes;
		}

		$sheet			= $this->_oPhpExcel->getSheet(0);
		$highestRow		= $sheet->getHighestRow();
		$highestColumn	= $sheet->getHighestColumn();

		if($highestRow == 1 && $highestColumn == 'A'){
			return array(
				'bExito'	=> false,
				'nCodigo'	=> '1014',
				'sMensaje'	=> 'No es posible leer el documento o se encuentra vacío'
			);
		}

		$this->oLayoutEstadoCuenta->setOPhpExcel($this->_oPhpExcel);
		$this->oLayoutEstadoCuenta->setNIdEstatus(0); # Buscar todos las configuraciones activas
		$encontrado = $this->oLayoutEstadoCuenta->obtenerFormatoLayout();

		$nIdBanco = self::getNIdBanco();

		if($encontrado){
			$nIdBancoLayout = $this->oLayoutEstadoCuenta->getNIdBanco();

			if($nIdBanco != $nIdBancoLayout){
				return array(
					'nCodigo'	=> '1015',
					'bExito'	=> false,
					'sMensaje'	=> 'El Archivo no coincide con el formato del Banco Seleccionado, Coincide con '.$this->oLayoutEstadoCuenta->getSNombreBanco()
				);
			}
		}
		else{
			return array(
				'nCodigo'	=> '1016',
				'bExito'	=> false,
				'sMensaje'	=> 'El Archivo no coincide con ningún formato registrado'
			);
		}

		$arrRes = self::_insertarMovimientos();

		return $arrRes;
	} # cargarMovimientos

	private function _initPhpExcel(){
		$oPhpExcel		= new PhpExcel();
		$inputFileName	= $this->_file['tmp_name'];

		try{
			$inputFileType	= PHPExcel_IOFactory::identify($inputFileName);
			$objReader		= PHPExcel_IOFactory::createReader($inputFileType);
			$objPHPExcel	= $objReader->load($inputFileName);

			$array = array(
				'nCodigo'		=> 0,
				'bExito'		=> true,
				'sMensaje'		=> 'Ok'
			);

			self::setOPhpExcel($objPHPExcel);
		}
		catch(Exception $e){

			$sMsgError = 'Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage();

			$array = array(
				'nCodigo'	=> 1,
				'bExito'	=> false,
				'sMensaje'	=> $sMsgError
			);
		}

		return $array;
	} # _initPhpExcel

	private function _insertarMovimientos(){
		$nIdBanco			= self::getNIdBanco();
		$nNumCuentaBancaria = self::getNNumCuentaBancaria();
		$nNumFilaInicial	= $this->oLayoutEstadoCuenta->getNNumFilaInicio();

		$oCfg	= self::_obtenerCfgBanco();
		$sheet	= $this->_oPhpExcel->getSheet(0);
		$maxRow	= $sheet->getHighestRow();

		for($i = $maxRow ; $i >= $nNumFilaInicial; $i--){
			$sCeldaDeposito = $oCfg->abono.$i;
			$sCeldaCargo	= $oCfg->cargo.$i;
			$sCeldaSaldo	= $oCfg->saldo.$i;
			$sCeldaConcepto	= $oCfg->concepto.$i;
			$sCeldaFecha	= $oCfg->fecha.$i;

			$nDeposito	= $sheet->getCell($sCeldaDeposito)->getValue();
			$nCargo		= $sheet->getCell($sCeldaCargo)->getValue();
			$nSaldo		= $sheet->getCell($sCeldaSaldo)->getValue();
			$sConcepto	= $sheet->getCell($sCeldaConcepto)->getValue();
			$dFecha		= self::_getHumanDate($sheet->getCell($sCeldaFecha)->getValue());

			$nDeposito	= ($nDeposito == null)? 0 : $nDeposito;
			$nCargo		= ($nCargo == null)? 0 : $nCargo;
			$nSaldo		= ($nSaldo == null)? 0 : $nSaldo;
			$sConcepto	= ($sConcepto == null)? '' : trim($sConcepto);
			$dFecha		= ($dFecha == null)? '' : trim($dFecha);

			$nAutorizacion = substr($sConcepto, -6, 6);
			$nAutorizacion = preg_replace("/[^0-9]/", "0", $nAutorizacion);

			$sConcepto	= substr($sConcepto, -100);

			$nMonto = 0;

			if($nDeposito > 0){
				$nMonto = $nDeposito;
			}

			if($nCargo > 0){
				$nMonto = $nCargo;
			}

			$sMonto = preg_replace("/[^0-9]/", "", $nMonto);
			$sSaldo = preg_replace("/[^0-9]/", "", $nSaldo);

			$idRegistro = $sSaldo.$sMonto.$nAutorizacion;
			#$idRegistro = substr($idRegistro, -16);
			#$idRegistro = str_pad($idRegistro, 16, "0", STR_PAD_LEFT);

			//$toHash		= $dFecha.$sConcepto.$nCargo.$nAbono.$nSaldo;
			$idRegistro = md5($idRegistro);

			$idTipoMov	= 0;
			$importe	= 0;

			if($nDeposito > 0){
				$idTipoMov	= 1;
				$importe	= $nDeposito;
			}

			if($nCargo > 0){
				$idTipoMov	= 2;
				$importe	= $nCargo;
			}

			$oBancoMov = new BancoMov();
			$oBancoMov->setORdb($this->oRdb);
			$oBancoMov->setOWdb($this->oWdb);
			$oBancoMov->setOLog($this->oLog);
			$oBancoMov->setIdRegistro($idRegistro);
			$oBancoMov->setIdEstatus(1);
			$oBancoMov->setIdTipoMov($idTipoMov);
			$oBancoMov->setIdBanco($nIdBanco);
			$oBancoMov->setBReferencia(0);
			$oBancoMov->setCuenta($nNumCuentaBancaria);
			$oBancoMov->setImporte($importe);
			$oBancoMov->setReferencia($sConcepto);
			$oBancoMov->setAutorizacion($nAutorizacion);
			$oBancoMov->setFecBanco($dFecha);
			$oBancoMov->setFecAplicacion($dFecha);

			$arrRes = $oBancoMov->insertar();
		} # for

		return $array = array(
			'bExito'	=> true,
			'nCodigo'	=> 0,
			'sMensaje'	=> 'Registros Insertados Correctamente'
		);
	} # _insertarMovimientos

	private function _obtenerCfgBanco(){
		$array = $this->oLayoutEstadoCuenta->getArrayLayoutCampo();

		$obj = new stdClass();

		$obj->fecha		= -1;
		$obj->concepto	= -1;
		$obj->cargo		= -1;
		$obj->abono		= -1;
		$obj->saldo		= -1;

		foreach($array as $oLayoutCampo){
			switch($oLayoutCampo->nIdCampo){
				case '1':
					$obj->fecha	= $oLayoutCampo->sPosicion;
				break;

				case '2':
					$obj->concepto = $oLayoutCampo->sPosicion;
				break;

				case '3':
					$obj->cargo = $oLayoutCampo->sPosicion;
				break;

				case '4':
					$obj->abono = $oLayoutCampo->sPosicion;
				break;

				case '5':
					$obj->saldo = $oLayoutCampo->sPosicion;
				break;
			}
		}

		return $obj;
	} # _obtenerCfgBanco
} # EstadoCuenta

?>