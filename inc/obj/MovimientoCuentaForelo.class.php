<?php

class MovimientoCuentaForelo{

	public $idsMovimiento;
	public $idsOperacion;
	public $fecAppMov;
	public $fecAppMovDate;
	public $cargoMov;
	public $abonoMov;
	public $comCorresponsal;
	public $saldoInicial;
	public $saldoFinal;
	public $tipoMov;
	public $descMovimiento;
	public $numCuenta;
	public $idEmpleado;
	public $nIdMovBanco;
	public $oRdb;
	public $oWdb;
	public $dFechaInicio;
	public $dFechaFinal;
	public $idUsuario;

	public function setIdsMovimiento($value){
		$this->idsMovimiento = $value;
	}

	public function getIdsMovimiento(){
		return $this->idsMovimiento;
	}

	public function setIdsOperacion($value){
		$this->idsOperacion = $value;
	}

	public function getIdsOperacion(){
		return $this->idsOperacion;
	}

	public function setFecAppMov($value){
		$this->fecAppMov = $value;
	}

	public function getFecAppMov(){
		return $this->fecAppMov;
	}

	public function setFecAppMovDate($value){
		$this->fecAppMovDate = $value;
	}

	public function getFecAppMovDate(){
		return $this->fecAppMovDate;
	}

	public function setCargoMov($value){
		$this->cargoMov = $value;
	}

	public function getCargoMov(){
		return $this->cargoMov;
	}

	public function setAbonoMov($value){
		$this->abonoMov = $value;
	}

	public function getAbonoMov(){
		return $this->abonoMov;
	}

	public function setComCorresponsal($value){
		$this->comCorresponsal = $value;
	}

	public function getComCorresponsal(){
		return $this->comCorresponsal;
	}

	public function setSaldoInicial($value){
		$this->saldoInicial = $value;
	}

	public function getSaldoInicial(){
		return $this->saldoInicial;
	}

	public function setSaldoFinal($value){
		$this->saldoFinal = $value;
	}

	public function getSaldoFinal(){
		return $this->saldoFinal;
	}

	public function setTipoMov($value){
		$this->tipoMov = $value;
	}

	public function getTipoMov(){
		return $this->tipoMov;
	}

	public function setDescMovimiento($value){
		$this->descMovimiento = $value;
	}

	public function getDescMovimiento(){
		return $this->descMovimiento;
	}

	public function setNumCuenta($value){
		$this->numCuenta = $value;
	}

	public function getNumCuenta(){
		return $this->numCuenta;
	}

	public function setIdEmpleado($value){
		$this->idEmpleado = $value;
	}

	public function getIdEmpleado(){
		return $this->idEmpleado;
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

	public function setNIdMovBanco($value){
		$this->nIdMovBanco = $value;
	}

	public function getNIdMovBanco(){
		return $this->nIdMovBanco;
	}

	public function setDFechaInicio($value){
		$this->dFechaInicio = $value;
	}

	public function getDFechaInicio(){
		return $this->dFechaInicio;
	}

	public function setDFechaFinal($value){
		$this->dFechaFinal = $value;
	}

	public function getDFechaFinal(){
		return $this->dFechaFinal;
	}

	public function setIdUsuario($value) {
		$this->idUsuario = $value;
	}

	public function getIdUsuario() {
		return $this->idUsuario;
	}
	# # # # # # # # # # # # # # # # # # # # # # # # # # #

	public function insertar(){
		$array_params = array(
			array(
				'name'	=> 'numCuenta',
				'value'	=> self::getNumCuenta(),
				'type'	=> 's'
			),
			array(
				'name'	=> 'nCargo',
				'value'	=> self::getCargoMov(),
				'type'	=> 'd'
			),
			array(
				'name'	=> 'nAbono',
				'value'	=> self::getAbonoMov(),
				'type'	=> 'd'
			),
			array(
				'name'	=> 'sDescripcion',
				'value'	=> self::getDescMovimiento(),
				'type'	=> 's'
			),
			array(
				'name'	=> 'nIdTipoMovimiento',
				'value'	=> self::getTipoMov(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nIdUsuario',
				'value'	=> self::getIdEmpleado(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nIdMovBanco',
				'value'	=> self::getNIdMovBanco(),
				'type'	=> 'i'
			)
		);

		$this->oWdb->setSDatabase('redefectiva');
		$this->oWdb->setSStoredProcedure('sp_insert_forelomanual');
		$this->oWdb->setParams($array_params);

		$resultado = $this->oWdb->execute();

		if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
			return $resultado;
		}

		$data = $this->oWdb->fetchAll();

		$this->oWdb->closeStmt();

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> '',
			'sMensajeDetallado'	=> '',
			'data'				=> $data
		);
	} # insertar

	public function insertarMovimiento(){
		$array_params = array(
			array(
				'name'	=> 'numeroCuenta',
				'type'	=> 'i',
				'value'	=> self::getNumCuenta()
			),
			array(
				'name'	=> 'cargo',
				'type'	=> 'd',
				'value'	=> self::getCargoMov()
			),
			array(
				'name'	=> 'abono',
				'type'	=> 'd',
				'value'	=> self::getAbonoMov()
			),
			array(
				'name'	=> 'descripcion',
				'type'	=> 's',
				'value'	=> self::getDescMovimiento()
			),
			array(
				'name'	=> 'tipoMovimiento',
				'type'	=> 'i',
				'value'	=> self::getTipoMov()
			),
			array(
				'name'	=> 'idUsuario',
				'type'	=> 'i',
				'value'	=> self::getIdUsuario()
			)
		);

		$this->oWdb->setSDatabase('redefectiva');
		$this->oWdb->setSStoredProcedure('SPO_MOVIMIENTO');
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
			'data'		=> $data,
			'nRows'		=> count($data)
		);
	} # inserta

	public function consulta($array_params){
		$this->oRdb->setSDatabase('redefectiva');
		//$this->oRdb->setSStoredProcedure('sp_select_movimientos');
		$this->oRdb->setSStoredProcedure('sp_select_movimientos_credito');
		$this->oRdb->setParams($array_params);

		$result = $this->oRdb->execute();

		if($result['nCodigo'] != 0 || $result['bExito'] == false){
			return $result;
		}

		$data = $this->oRdb->fetchAll();

		$this->oRdb->closeStmt();

		$num_rows = $this->oRdb->foundRows();

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> 'Consulta Movimientos Ok',
			'sMensajeDetallado'	=> '',
			'data'				=> $data,
			'num_rows'			=> $num_rows
		);
	} # consulta

} # MovimientoCuentaForelo

?>