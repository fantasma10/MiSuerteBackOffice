<?php

class LayoutEstadoCuenta{

	public $oRdb;
	public $oWdb;
	public $oLog;
	public $nIdLayout;
	public $nIdBanco;
	public $nIdEstatus;
	public $nNumFilaInicio;
	public $sNombreCampo;
	public $sNombreBanco;

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

	public function setOLog($value){
		$this->oLog = $value;
	}

	public function getOLog(){
		return $this->oLog;
	}

	public function setNIdLayout($value){
		$this->nIdLayout = $value;
	}

	public function getNIdLayout(){
		return $this->nIdLayout;
	}

	public function setNIdBanco($value){
		$this->nIdBanco = $value;
	}

	public function getNIdBanco(){
		return $this->nIdBanco;
	}

	public function setNIdEstatus($value){
		$this->nIdEstatus = $value;
	}

	public function getNIdEstatus(){
		return $this->nIdEstatus;
	}

	public function setNNumFilaInicio($value){
		$this->nNumFilaInicio = $value;
	}

	public function getNNumFilaInicio(){
		return $this->nNumFilaInicio;
	}

	public function setSNombreCampo($value){
		$this->sNombreCampo = $value;
	}

	public function getSNombreCampo(){
		return $this->sNombreCampo;
	}

	public function setSNombreBanco($sNombreBanco){
		$this->sNombreBanco = $sNombreBanco;
	}

	public function getSNombreBanco(){
		return $this->sNombreBanco;
	}

	public function setOPhpExcel($_oPhpExcel){
		$this->_oPhpExcel = $_oPhpExcel;
	}

	public function setArrayLayoutCampo($arrayLayoutCampo){
		$this->arrayLayoutCampo = $arrayLayoutCampo;
	}

	public function getArrayLayoutCampo(){
		return $this->arrayLayoutCampo;
	}

	public function cargarCfg(){
		$array_params = array(
			array(
				'name'	=> 'nIdBanco',
				'value'	=> self::getNIdBanco(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nIdEstatus',
				'value'	=> self::getNIdEstatus(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'bEsCfg',
				'value'	=> 1,
				'type'	=> 'i'
			),
			array(
				'name'	=> 'bEsCampos',
				'value'	=> 0,
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nIdLayout',
				'value'	=> 0,
				'type'	=> 'i'
			)
		);

		$this->oRdb->setBDebug(1);
		$this->oRdb->setSDatabase('redefectiva');
		$this->oRdb->setSStoredProcedure('SP_SELECT_LAYOUTCFG');
		$this->oRdb->setParams($array_params);
		$this->oRdb->execute();

		$arrRes = $this->oRdb->fetchAll();
		$this->oRdb->freeResult();
		$this->oRdb->closeStmt();

		$result = false;

		foreach($arrRes as $array){
			self::setNIdLayout($array['nIdLayout']);
			self::setNIdBanco($array['nIdBanco']);
			self::setNIdEstatus($array['nIdEstatus']);
			self::setNNumFilaInicio($array['nNumFilaInicio']);
			self::setSNombreBanco($array['sNombreBanco']);

			$array_params = array(
				array(
					'name'	=> 'nIdBanco',
					'value'	=> self::getNIdBanco(),
					'type'	=> 'i'
				),
				array(
					'name'	=> 'nIdEstatus',
					'value'	=> self::getNIdEstatus(),
					'type'	=> 'i'
				),
				array(
					'name'	=> 'bEsCfg',
					'value'	=> 0,
					'type'	=> 'i'
				),
				array(
					'name'	=> 'bEsCampos',
					'value'	=> 1,
					'type'	=> 'i'
				),
				array(
					'name'	=> 'nIdLayout',
					'value'	=> self::getNIdLayout(),
					'type'	=> 'i'
				)
			);

			$this->oRdb->setSDatabase('redefectiva');
			$this->oRdb->setSStoredProcedure('SP_SELECT_LAYOUTCFG');
			$this->oRdb->setParams($array_params);

			$this->oRdb->execute();

			$arrRes = $this->oRdb->fetchObject("LayoutCampo");
			self::setArrayLayoutCampo($arrRes);

			$result = self::_validarEncabezado();

			if($result){
				break;
			}

			$this->oRdb->freeResult();
			$this->oRdb->closeStmt();
		}


		return $result;
	} # cargarCfg

	private function _validarEncabezado(){
		$nNumFilaInicio		= self::getNNumFilaInicio();
		$nNumFilaEncabezado = $nNumFilaInicio - 1;
		$arrayLayoutCampo	= self::getArrayLayoutCampo();
		$sheet				= $this->_oPhpExcel->getSheet(0);
		$length				= count($arrayLayoutCampo);
		$nNumIguales		= 0;

		foreach($arrayLayoutCampo as $oLayoutCampo){
			$sLetraCelda	= $oLayoutCampo->getSPosicion();
			$sCelda			= $sLetraCelda.$nNumFilaEncabezado;

			$sTituloCelda		= trim($sheet->getCell($sCelda)->getValue());
			$sTituloConfigurado	= trim($oLayoutCampo->getSTitulo());
			$sTituloConfigurado	= utf8_encode($sTituloConfigurado);

			if($sTituloCelda == $sTituloConfigurado){
				$nNumIguales++;
			}

			if($nNumIguales == $length){
				break;
			}
		}

		if($nNumIguales == $length){
			return true;
		}
		else{
			return false;
		}
	} # _validarEncabezado

	public function obtenerFormatoLayout(){
		return self::cargarCfg();
	} # validarFormatoLayout
} # LayoutEstadoCuenta

?>