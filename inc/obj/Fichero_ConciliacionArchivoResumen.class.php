<?php

class ConciliacionArchivoResumen extends Fichero{

	public $oEncabezado = null;
	public $oRegistro	= null;
	public $oRdb		= null;
	public $oWdb		= null;

	public $sNombre					= '';
	public $dFecha					= '';
	public $nIdCorte				= 0;
	public $nIdNivelConciliacion	= 0;

	private $nIdCadena				= 0;
	private $dFechaAConciliar		= '';

	public function setOEncabezado($oEncabezado){
		$this->oEncabezado = $oEncabezado;
	}

	public function getOEncabezado(){
		return $this->oEncabezado;
	}

	public function setORegistro($oRegistro){
		$this->oRegistro = $oRegistro;
	}

	public function getORegistro(){
		return $this->oRegistro;
	}

	public function setORdb($oRdb){
		$this->oRdb = $oRdb;
	}

	public function getORdb(){
		return $this->oRdb;
	}

	public function setOWdb($oWdb){
		$this->oWdb = $oWdb;
	}

	public function getOWdb(){
		return $this->oWdb;
	}

	public function setSNombre($value) {
		$this->sNombre = $value;
	}

	public function getSNombre() {
		return $this->sNombre;
	}

	public function setDFecha($value) {
		$this->dFecha = $value;
	}

	public function getDFecha() {
		return $this->dFecha;
	}

	public function setNIdCorte($value) {
		$this->nIdCorte = $value;
	}

	public function getNIdCorte() {
		return $this->nIdCorte;
	}

	public function setNIdNivelConciliacion($nIdNivelConciliacion){
		$this->nIdNivelConciliacion = $nIdNivelConciliacion;
	}

	public function getNIdNivelConciliacion(){
		return $this->nIdNivelConciliacion;
	}

	private function setNIdCadena($nIdCadena){
		$this->nIdCadena = $nIdCadena;
	}

	private function getNIdCadena(){
		return $this->nIdCadena;
	}

	private function setDFechaAConciliar($dFechaAConciliar){
		$this->dFechaAConciliar = $dFechaAConciliar;
	}

	private function getDFechaAConciliar(){
		return $this->dFechaAConciliar;
	}

	public function obtenerTodasLasLineas(){
		parent::setMaxLine(null);
		parent::setEveryLine();
		$array_lineas = parent::getEveryLine();

		return $array_lineas;
	} # obtenerTodasLasLineas

	public function conciliar(){
		$nIdNivelConciliacion	= $this->getNIdNivelConciliacion();
		$nIdCorte				= $this->getNIdCorte();

		$nImpComision	= 0;
		$nPerComision	= 0;

		$oCorte = new CorteDiario();
		$oCorte->setORdb($this->oRdb);
		$oCorte->setOWdb($this->oWdb);
		$oCorte->setNIdNivelConciliacion($nIdNivelConciliacion);
		$oCorte->setNIdCorte($nIdCorte);
		$resultado = $oCorte->sp_select_corte();
		#echo '<pre>'; var_dump($resultado); echo '</pre>';
		if(!$resultado['bExito']){
			$resultado['sMensaje'] = 'No ha sido posible obtener informacion del corte';
			return $resultado;
		}

		if($resultado['found_rows'] == 0){
			return array(
				'bExito'	=> false,
				'nCodigo'	=> 2,
				'sMensaje'	=> 'No se encuentra Corte para la Fecha y Cadena seleccionadas'
			);
		}

		$data = $resultado['data'];

		if(count($data) > 0){
			$nIdCadena			= $data[0]['nIdCadena'];
			$nIdSubCadena		= $data[0]['nIdSubCadena'];
			$nIdCorresponsal	= $data[0]['nIdCorresponsal'];
			$dFecha				= $data[0]['dFecha'];

			$this->setNIdCadena($nIdCadena);
			$this->setDFechaAConciliar($dFecha);
		}
		else{
			return array(
				'bExito'	=> false,
				'nCodigo'	=> 2,
				'sMensaje'	=> 'No se encuentra Corte'
			);
		}

		$dFechaAConciliar	= str_replace('-', '', $this->dFechaAConciliar);
		$dFechaAConciliar	= date('dmY', strtotime($dFechaAConciliar));

		$oTipoConciliacion = new TipoConciliacion();
		$oTipoConciliacion->setORdb($this->oRdb);
		$oTipoConciliacion->setNIdCadena($nIdCadena);
		$oTipoConciliacion->setDFechaAConciliar($dFechaAConciliar);
		$resultado = $oTipoConciliacion->load_tipo_conciliacion();

		if(!$resultado['bExito']){
			return $resultado;
		}

		$resultado = $this->_cargarLayoutCfg();

		if(!$resultado['bExito']){
			return $resultado;
		}

		$array_cfgLayout = $resultado['datos'];

		$array_lineas = $this->obtenerTodasLasLineas();
		$resultado = $oTipoConciliacion->procesaLineas($array_lineas, $array_cfgLayout);

		if(!$resultado['bExito']){
			return $resultado;
		}

		$nOperaciones			= $resultado['nLineasProcesadas'];
		$nMonto					= $resultado['nImporteTotal'];
		$nMontoComision			= $resultado['nComisionTotal'];
		$nMontoComisionEspecial	= 0;
		$array_operaciones		= $resultado['oOperaciones'];

		$oEncabezado = new ArchivoEncabezado();
		$oEncabezado->setOWdb($this->oWdb);
		$oEncabezado->setNIdNivelConciliacion($this->nIdNivelConciliacion);
		$oEncabezado->setNIdCadena($this->nIdCadena);
		$oEncabezado->setNIdSubCadena($nIdSubCadena);
		$oEncabezado->setNIdCorresponsal($nIdCorresponsal);
		$oEncabezado->setNIdCorte($nIdCorte);
		$oEncabezado->setSNombreArchivo($this->sNombre);
		$oEncabezado->setDFecha($this->dFechaAConciliar);
		$oEncabezado->setNMonto($nMonto);
		$oEncabezado->setNMontoComision($nMontoComision);
		$oEncabezado->setNMontoComisionEspecial($nMontoComisionEspecial);
		$oEncabezado->setNOperaciones($nOperaciones);
		$resultado = $oEncabezado->guardar();

		if(!$resultado['bExito']){
			return $resultado;
		}

		$array_errores = array(
			'nOperaciones'		=> 0,
			'nMonto'			=> 0,
			'nMontoComision'	=> 0,
			'errores'			=> array()
		);

		$nIdArchivo = $resultado['data'][0]['nIdArchivo'];

		foreach($array_operaciones AS $operacion){
			$operacion->setNIdArchivo($nIdArchivo);
			$operacion->setOWdb($this->oWdb);
			$resultado = $operacion->guardar();

			if(!$resultado['bExito']){
				$array_errores['nOperaciones']		+= 1;
				$array_errores['nMonto']			+= $operacion->nImporte;
				$array_errores['nMontoComision']	+= $operacion->nComision;
				$array_errores['errores'][]			= $resultado['sMensajeDetallado'];
			}
		} # foreach

		$oConciliacion  = new ConciliacionOperacion();
		$oConciliacion->setORdb($this->oRdb);
		$oConciliacion->setOWdb($this->oWdb);
		$oConciliacion->setNIdArchivo($nIdArchivo);
		$oConciliacion->setNIdNivelConciliacion($nIdNivelConciliacion);
		$oConciliacion->setNIdCadena($nIdCadena);
		$oConciliacion->setNIdSubCadena($nIdSubCadena);
		$oConciliacion->setNIdCorresponsal($nIdCorresponsal);
		$oConciliacion->setNIdCorte($nIdCorte);
		$resultado = $oConciliacion->conciliar();

		return $resultado;
	} # conciliar

	private function _obtenerCamposCfg(){
		$array_params = array();

		$this->oRdb->setSDatabase($_SESSION['db']);
		$this->oRdb->setSStoredProcedure('sp_select_campo_conciliacion');
		$this->oRdb->setParams($array_params);

		$resultado = $this->oRdb->execute();

		if(!$resultado['bExito'] || $resultado['nCodigo'] != 0){
			$resultado['sMensaje'] = 'No ha sido posible cargar la informacion de layout';
			return $resultado;
		}

		$data = $this->oRdb->fetchAll();
		$this->oRdb->closeStmt();

		$found_rows = $this->oRdb->foundRows();
		$this->oRdb->closeStmt();

		$datos = array();

		if($found_rows > 0){
			foreach($data AS $fila){
				$oCampo = new PC_CampoConciliacion();

				foreach($fila AS $prop => $valor){
					if(property_exists('PC_CampoConciliacion', $prop)){
						$oCampo->$prop = $valor;
					}
				}

				$datos[] = $oCampo;
			}
		}

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> 'Consulta Ok',
			'sMensajeDetallado'	=> 'Consulta Ok',
			'data'				=> $datos,
			'found_rows'		=> $found_rows
		);
	} # _obtenerCamposCfg


	private function _cargarLayoutCfg(){
		$oCfgLayout = new ClienteCfgLayout();
		$oCfgLayout->setNIdCadena($this->nIdCadena);
		$oCfgLayout->setORdb($this->oRdb);
		$resultado = $oCfgLayout->cargarClienteCfgLayout();

		if(!$resultado['bExito']){
			$resultado['sMensaje'] = 'No fue posible cargar la configuracion de layout';
			return $resultado;
		}

		$datos = array();

		if($resultado['found_rows'] > 0){
			$data = $resultado['data'];

			foreach($data AS $fila){
				$oCfgLayout = new ClienteCfgLayout();

				foreach($fila AS $prop => $valor){
					if(property_exists('ClienteCfgLayout', $prop)){
						$oCfgLayout->$prop = $valor;
					}
				}

				$datos[] =  $oCfgLayout;
			}
		}
		else{
			return array(
				'bExito'	=> false,
				'nCodigo'	=> 1,
				'sMensaje'	=> 'No se encontro configuracion de layout'
			);
		}

		return array(
			'bExito'	=> true,
			'nCodigo'	=> 0,
			'sMensaje'	=> 'Ok',
			'datos'		=> $datos
		);
	} # _cargarLayoutCfg
} # PC_ArchivoOperaciones

?>