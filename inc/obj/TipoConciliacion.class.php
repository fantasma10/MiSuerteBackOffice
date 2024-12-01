<?php

class TipoConciliacion{

	public $nId;
	public $nIdEstatus;
	public $nIdNivelConciliacion;
	public $nIdCadena;
	public $nIdTipoConciliacion;
	public $bConDecimales;
	public $sCaracter;
	public $dFecRegistro;
	public $dFecMovimiento;
	public $sNivelConciliacion;
	public $nombreCadena;
	public $dFechaAConciliar;
	public $oRdb;
	public $oWdb;

	public function setNId($value){
		$this->nId = $value;
	}

	public function getNId(){
		return $this->nId;
	}

	public function setNIdEstatus($value){
		$this->nIdEstatus = $value;
	}

	public function getNIdEstatus(){
		return $this->nIdEstatus;
	}

	public function setNIdNivelConciliacion($value){
		$this->nIdNivelConciliacion = $value;
	}

	public function getNIdNivelConciliacion(){
		return $this->nIdNivelConciliacion;
	}

	public function setNIdCadena($value){
		$this->nIdCadena = $value;
	}

	public function getNIdCadena(){
		return $this->nIdCadena;
	}

	public function setNIdTipoConciliacion($value){
		$this->nIdTipoConciliacion = $value;
	}

	public function getNIdTipoConciliacion(){
		return $this->nIdTipoConciliacion;
	}

	public function setBConDecimales($value){
		$this->bConDecimales = $value;
	}

	public function getBConDecimales(){
		return $this->bConDecimales;
	}

	public function setSCaracter($value){
		$this->sCaracter = $value;
	}

	public function getSCaracter(){
		return $this->sCaracter;
	}

	public function setDFecRegistro($value){
		$this->dFecRegistro = $value;
	}

	public function getDFecRegistro(){
		return $this->dFecRegistro;
	}

	public function setDFecMovimiento($value){
		$this->dFecMovimiento = $value;
	}

	public function getDFecMovimiento(){
		return $this->dFecMovimiento;
	}

	public function setSNivelConciliacion($value){
		$this->sNivelConciliacion = $value;
	}

	public function getSNivelConciliacion(){
		return $this->sNivelConciliacion;
	}

	public function setNombreCadena($value){
		$this->nombreCadena = $value;
	}

	public function getNombreCadena(){
		return $this->nombreCadena;
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

	public function setDFechaAConciliar($dFechaAConciliar){
		$this->dFechaAConciliar = $dFechaAConciliar;
	}

	public function getDFechaAConciliar(){
		return $this->dFechaAConciliar;
	}

	public function load_tipo_conciliacion(){
		$resultado = $result = $this->select_tipo_conciliacion();

		if(!$resultado['bExito']){
			return $resultado;
		}

		$found_rows	= $resultado['found_rows'];

		if($found_rows > 0){
			$data = $resultado['data'][0];

			foreach($data AS $key => $value){
				if(property_exists('TipoConciliacion', $key)){
					$this->$key = $value;
				}
			}

			$resultado = array(
				'bExito'	=> true,
				'nCodigo'	=> 0
			);
		}
		else{
			$resultado = array(
				'bExito'	=> true,
				'nCodigo'	=> '1',
				'sMensaje'	=> 'No se encontro informacion'
			);
		}

		return $resultado;
	} # load_tipo_conciliacion

	public function select_tipo_conciliacion($sortCol = 0, $sortDir = 'ASC', $start = 0, $limit = 1){
		$array_params = array(
			array(
				'name'	=> 'nIdCadena',
				'value'	=> self::getNIdCadena(),
				'type'	=> 'i'
			),
			array(
				'name'		=> 'sortCol',
				'value'		=> $sortCol,
				'type'		=> 'i'
			),
			array(
				'name'		=> 'sortDir',
				'value'		=> $sortDir,
				'type'		=> 's'
			),
			array(
				'name'		=> 'start',
				'value'		=> $start,
				'type'		=> 'i'
			),
			array(
				'name'		=> 'limit',
				'value'		=> $limit,
				'type'		=> 'i'
			)
		);

		$this->oRdb->setSDatabase('data_contable');
		$this->oRdb->setSStoredProcedure('sp_select_tipo_conciliacion');
		$this->oRdb->setParams($array_params);

		$resultado = $this->oRdb->execute();

		if(!$resultado['bExito'] || $resultado['nCodigo'] != 0){
			return $resultado;
		}

		$data = $this->oRdb->fetchAll();
		$this->oRdb->closeStmt();

		$found_rows = $this->oRdb->foundRows();
		$this->oRdb->closeStmt();

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> 'Consulta Ok',
			'sMensajeDetallado'	=> 'Consulta Ok',
			'data'				=> $data,
			'found_rows'		=> $found_rows
		);
	} # select_tipo_conciliacion

	public function select_cat_tipo_conciliacion(){
		$array_params = array(
			array(
				'name'		=> 'nIdTipoConciliacion',
				'value'		=> self::getNIdTipoConciliacion(),
				'type'		=> 'i'
			)
		);

		$this->oRdb->setSDatabase('data_contable');
		$this->oRdb->setSStoredProcedure('sp_select_tipoconciliacion');
		$this->oRdb->setParams($array_params);

		$resultado = $this->oRdb->execute();

		if(!$resultado['bExito'] || $resultado['nCodigo'] != 0){
			return $resultado;
		}

		$data = $this->oRdb->fetchAll();
		$this->oRdb->closeStmt();

		$found_rows = $this->oRdb->foundRows();
		$this->oRdb->closeStmt();

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> 'Consulta Ok',
			'sMensajeDetallado'	=> 'Consulta Ok',
			'data'				=> $data,
			'found_rows'		=> $found_rows
		);
	} # select_cat_tipo_conciliacion

	public function procesaLineas($array_lineas, $array_cfgLayout){
		switch($this->nIdTipoConciliacion){
			case '1':
				return $this->_layout1($array_lineas, $array_cfgLayout);
			break;

			case '2':
				return $this->_layout2($array_lineas);
			break;
		}
	} # procesaLineas

	/*
		Cada linea la convierte en un arreglo creando los elementos del arreglo al separar por el caracter configurado
	*/
	private function _layout1($array_lineas, $array_cfgLayout){
		if(!empty($array_lineas)){
			$sCaracter				= $this->getSCaracter();
			$bConDecimales			= $this->getBConDecimales();
			$count					= 0;
			$array_lineas_archivo	= array();
			$nTotalLineas			= count($array_lineas);
			$nLineasProcesadas		= 0;
			$nImporteTotal			= 0;
			$nComisionTotal			= 0;

			foreach($array_lineas AS $linea){
				//if($count > 0){
					$array_datos		= explode($sCaracter, $linea);
					$oArchivoOperacion	= new ArchivoOperacion();

					$cfgInicial 	= $array_cfgLayout[0];
					$nPos			= $cfgInicial->nPosicionInicial;
					$idRegistro		= (!empty($array_datos[$nPos]))? trim($array_datos[$nPos]) : '';
					$sValorComparar	= $cfgInicial->sValorComparar;

					if($cfgInicial->sCampoClase == 'sIdentificador' && ($sValorComparar == $idRegistro || ($sValorComparar == 199 && $idRegistro != 198))){

						$bMismaFecha	= true;
						$nImporteActual = 0;

						foreach($array_cfgLayout as $cfg){
							$nPos	= $cfg->nPosicionInicial;
							$valor	= (!empty($array_datos[$nPos]))? $array_datos[$nPos] : '';

							if(property_exists('ArchivoOperacion', $cfg->sCampoClase)){
								$prop = $cfg->sCampoClase;

								if($cfg->sCampoClase == 'dFecha'){
									if(strpos($valor, '-') > 0 || strpos($valor, '/')){
										$date	= str_replace('/', '-', $valor);
										$valor	= date('dmY', strtotime($date));
									}
									if($valor != $this->dFechaAConciliar){
										$bMismaFecha = false;
									}
								}

								if($bMismaFecha){
									if($bConDecimales == 1 && ($cfg->sCampoClase == 'nImporte' || $cfg->sCampoClase == 'nComision')){
										$trimmed	= ltrim($valor, '0');
										$valor		= str_replace('.', '', $trimmed);
									}

									if($cfg->sCampoClase == 'nImporte'){
										$nImporteTotal+= $valor;
										$nImporteActual = $valor;
									}

									if($cfg->sCampoClase == 'nComision'){
										if((empty($valor) || $valor == '00') && (!empty($this->nImpComision) || !empty($this->nPerComision))){
											if(!empty($this->nImpComision)){
												$valor = $this->nImpComision * 100;
											}

											if(!empty($this->nPerComision)){
												$per = $nImporteActual * $this->nPerComision;
												$valor += $per;
											}
										}
										$nComisionTotal += $valor;

									}
									

									if($cfg->sCampoClase == 'dHora'){
										if(strpos($valor, ':')){
											$valor = str_replace(':', '', $valor);
										}
									}

									$valor = trim($valor);

									$oArchivoOperacion->$prop = $valor;
								}
							}

						}# foreach

						if($bMismaFecha){
							$nLineasProcesadas++;
							$array_lineas_archivo[] = $oArchivoOperacion;
						}

					}
				//} # if
				$count++;
			} # foreach
		}
		else{
			$resultado = array(
				'bExito'	=> false,
				'nCodigo'	=> 1,
				'sMensaje'	=> 'No se recibio informacion'
			);
		}

		$resultado = array(
			'bExito'			=> true,
			'nLineasProcesadas'	=> $nLineasProcesadas,
			'nImporteTotal'		=> $nImporteTotal,
			'nComisionTotal'	=> $nComisionTotal,
			'oOperaciones'		=> $array_lineas_archivo
		);

		return $resultado;
	} # _layout1

	private function _layout2($array_lineas){

	} # _layout2

	private function _procesaFila1($cfg, $linea){
		echo '<pre>'; var_dump($cfg, $linea); echo '</pre>';
	} # _procesaFila1

	public function updateTipoConciliacion(){
		$array_params = array(
			array(
				'name'	=> 'nIdCadena',
				'value'	=> self::getNIdCadena(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nIdNivelConciliacion',
				'value'	=> self::getNIdNivelConciliacion(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nIdTipoConciliacion',
				'value'	=> self::getNIdTipoConciliacion(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'bConDecimales',
				'value'	=> self::getBConDecimales(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'sCaracter',
				'value'	=> self::getSCaracter(),
				'type'	=> 's'
			)
		);

		$this->oWdb->setSDatabase('data_contable');
		$this->oWdb->setSStoredProcedure('sp_update_cliente_tipoconciliacion');
		$this->oWdb->setParams($array_params);

		$resultado = $this->oWdb->execute();

		if(!$resultado['bExito'] || $resultado['nCodigo'] != 0){
			return $resultado;
		}

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> 'Consulta Ok',
			'sMensajeDetallado'	=> 'Consulta Ok',
			'data'				=> array(),
			'found_rows'		=> 0
		);
	} # _updateTIpoConciliacion
} # PC_TipoConciliacion

?>