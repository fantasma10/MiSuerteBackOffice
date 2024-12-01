<?php

class ArchivoEncabezado{

	public $nIdArchivo;
	public $nIdEstatus;
	public $nIdNivelConciliacion;
	public $nIdCadena;
	public $nIdSubCadena;
	public $nIdCorresponsal;
	public $nIdCorte;
	public $sNombreArchivo;
	public $dFecha;
	public $nOperaciones;
	public $nMonto;
	public $nMontoComision;
	public $nMontoComisionEspecial;
	public $dFecRegistro;
	public $dFecMovimiento;
	public $oRdb;
	public $oWdb;

	public function setNIdArchivo($value){
		$this->nIdArchivo = $value;
	}

	public function getNIdArchivo(){
		return $this->nIdArchivo;
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

	public function setNIdSubCadena($value){
		$this->nIdSubCadena = $value;
	}

	public function getNIdSubCadena(){
		return $this->nIdSubCadena;
	}

	public function setNIdCorresponsal($value){
		$this->nIdCorresponsal = $value;
	}

	public function getNIdCorresponsal(){
		return $this->nIdCorresponsal;
	}

	public function setNIdCorte($value){
		$this->nIdCorte = $value;
	}

	public function getNIdCorte(){
		return $this->nIdCorte;
	}

	public function setSNombreArchivo($value){
		$this->sNombreArchivo = $value;
	}

	public function getSNombreArchivo(){
		return $this->sNombreArchivo;
	}

	public function setDFecha($value){
		$this->dFecha = $value;
	}

	public function getDFecha(){
		return $this->dFecha;
	}

	public function setNOperaciones($value){
		$this->nOperaciones = $value;
	}

	public function getNOperaciones(){
		return $this->nOperaciones;
	}

	public function setNMonto($value){
		$this->nMonto = $value;
	}

	public function getNMonto(){
		return $this->nMonto;
	}

	public function setNMontoComision($value){
		$this->nMontoComision = $value;
	}

	public function getNMontoComision(){
		return $this->nMontoComision;
	}

	public function setNMontoComisionEspecial($value){
		$this->nMontoComisionEspecial = $value;
	}

	public function getNMontoComisionEspecial(){
		return $this->nMontoComisionEspecial;
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

	/*
		El sp recibe los montos como enteros con las dos decimales y los divide entre 100 para mostrar el punto decimal
	*/
	public function guardar(){
		$array_params = array(
			array(
				'name'	=> 'nIdNivelConciliacion',
				'value'	=> self::getNIdNivelConciliacion(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nIdCadena',
				'value'	=> self::getNIdCadena(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nIdSubCadena',
				'value'	=> self::getNIdSubCadena(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nIdCorresponsal',
				'value'	=> self::getNIdCorresponsal(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nIdCorte',
				'value'	=> self::getNIdCorte(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'sNombreArchivo',
				'value'	=> self::getSNombreArchivo(),
				'type'	=> 's'
			),
			array(
				'name'	=> 'dFecha',
				'value'	=> self::getDFecha(),
				'type'	=> 's'
			),
			array(
				'name'	=> 'nOperaciones',
				'value'	=> self::getNOperaciones(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nMonto',
				'value'	=> self::getNMonto(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nMontoComision',
				'value'	=> self::getNMontoComision(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nMontoComisionEspecial',
				'value'	=> self::getNMontoComisionEspecial(),
				'type'	=> 'i'
			)
		);

		$this->oWdb->setSDatabase('data_contable');
		$this->oWdb->setSStoredProcedure('sp_insert_archivo_encabezado');
		$this->oWdb->setParams($array_params);

		$resultado = $this->oWdb->execute();

		if(!$resultado['bExito'] || $resultado['nCodigo'] != 0){
			$resultado['sMensaje'] = 'No ha sido posible guardar la informacion de Encabezado de Archivo';
			return $resultado;
		}

		$data = $this->oWdb->fetchAll();
		$this->oWdb->closeStmt();

		$res = $data[0];

		$bExito		= ($res['nCodigo'] == 0)? true : false;
		$nCodigo	= $res['nCodigo'];
		$sMensaje	= $res['sMensaje'];

		return array(
			'bExito'			=> $bExito,
			'nCodigo'			=> $nCodigo,
			'sMensaje'			=> $sMensaje,
			'sMensajeDetallado'	=> '',
			'data'				=> $data
		);
	} # guardar

	public function select_archivo_encabezado($start=0,$limit=-1){
		$array_params = array(
			array(
				'name'		=> 'nIdArchivo',
				'value'		=> self::getNIdArchivo(),
				'type'		=> 'i'
			),
			array(
				'name'		=> 'nIdTipoCliente',
				'value'		=> self::getNIdTipoCliente(),
				'type'		=> 'i'
			),
			array(
				'name'		=> 'nIdCliente',
				'value'		=> self::getNIdCliente(),
				'type'		=> 'i'
			),
			array(
				'name'		=> 'dFecha',
				'value'		=> self::getDFecha(),
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

		$this->oRdb->setSDatabase($_SESSION['db']);
		$this->oRdb->setSStoredProcedure('sp_select_archivo_encabezado');
		$this->oRdb->setParams($array_params);

		$resultado = $this->oRdb->execute();

		if(!$resultado['bExito'] || $resultado['nCodigo'] != 0){
			$resultado['sMensaje'] = 'No ha sido posible obtener la informacion del Archivo';
			return $resultado;
		}

		$data = $this->oRdb->fetchAll();
		$this->oRdb->closeStmt();

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> 'Consulta Exitosa',
			'sMensajeDetallado'	=> '',
			'data'				=> $data
		);
	} # select_archivo_encabezado
} #PC_Archivo

?>