<?php

class Deposito{

	public $oRdb;
	public $oWdb;
	public $oLog;
	public $idDeposito;
	public $numCuenta;
	public $importe;
	public $autorizacion;
	public $descripcion;
	public $tipoDeposito;
	public $fechaDeposito;
	public $fechaSolicitud;
	public $fechaAplicacion;
	public $idEstatus;
	public $idEmpleado;
	public $idBanco;
	public $idUsuario;
	public $idMovimiento;

	public $dFechaInicio;
	public $dFechaFinal;

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

	public function setIdDeposito($value){
		$this->idDeposito = $value;
	}

	public function getIdDeposito(){
		return $this->idDeposito;
	}

	public function setNumCuenta($value){
		$this->numCuenta = $value;
	}

	public function getNumCuenta(){
		return $this->numCuenta;
	}

	public function setImporte($value){
		$this->importe = $value;
	}

	public function getImporte(){
		return $this->importe;
	}

	public function setAutorizacion($value){
		$this->autorizacion = $value;
	}

	public function getAutorizacion(){
		return $this->autorizacion;
	}

	public function setDescripcion($value){
		$this->descripcion = $value;
	}

	public function getDescripcion(){
		return $this->descripcion;
	}

	public function setTipoDeposito($value){
		$this->tipoDeposito = $value;
	}

	public function getTipoDeposito(){
		return $this->tipoDeposito;
	}

	public function setFechaDeposito($value){
		$this->fechaDeposito = $value;
	}

	public function getFechaDeposito(){
		return $this->fechaDeposito;
	}

	public function setFechaSolicitud($value){
		$this->fechaSolicitud = $value;
	}

	public function getFechaSolicitud(){
		return $this->fechaSolicitud;
	}

	public function setFechaAplicacion($value){
		$this->fechaAplicacion = $value;
	}

	public function getFechaAplicacion(){
		return $this->fechaAplicacion;
	}

	public function setIdEstatus($value){
		$this->idEstatus = $value;
	}

	public function getIdEstatus(){
		return $this->idEstatus;
	}

	public function setIdEmpleado($value){
		$this->idEmpleado = $value;
	}

	public function getIdEmpleado(){
		return $this->idEmpleado;
	}

	public function setIdBanco($value){
		$this->idBanco = $value;
	}

	public function getIdBanco(){
		return $this->idBanco;
	}

	public function setIdUsuario($value){
		$this->idUsuario = $value;
	}

	public function getIdUsuario(){
		return $this->idUsuario;
	}

	public function setIdMovimiento($value){
		$this->idMovimiento = $value;
	}

	public function getIdMovimiento(){
		return $this->idMovimiento;
	}

	public function setDFechaInicio($dFechaInicio){
		$this->dFechaInicio = $dFechaInicio;
	}

	public function getDFechaInicio(){
		return $this->dFechaInicio;
	}

	public function setDFechaFinal($dFechaFinal){
		$this->dFechaFinal = $dFechaFinal;
	}

	public function getDFechaFinal(){
		return $this->dFechaFinal;
	}

	# # # # # # # # # # # # # # # # # # # # #

	public function consultar(){
		$array_params = array(
			array(
				'name'	=> 'nIdBanco',
				'type'	=> 'i',
				'value'	=> self::getIdBanco()
			),
			array(
				'name'	=> 'nIdDeposito',
				'type'	=> 'i',
				'value'	=> self::getIdDeposito()
			),
			array(
				'name'	=> 'dFechaInicio',
				'type'	=> 's',
				'value'	=> self::getDFechaInicio()
			),
			array(
				'name'	=> 'dFechaFinal',
				'type'	=> 's',
				'value'	=> self::getDFechaFinal()
			),
			array(
				'name'	=> 'nIdEstatus',
				'type'	=> 's',
				'value'	=> self::getIdEstatus()
			),
			array(
				'name'	=> 'nNumCuenta',
				'type'	=> 's',
				'value'	=> self::getNumCuenta()
			)
		);

		$this->oRdb->setSDatabase('redefectiva');
		$this->oRdb->setSStoredProcedure('SP_SELECT_DEPOSITOS');
		$this->oRdb->setParams($array_params);
		$arrRes	= $this->oRdb->execute();

		if($arrRes['nCodigo'] > 0 || $arrRes['bExito'] == false){
			return $arrRes;
		}

		$data	= $this->oRdb->fetchAll();
		$count	= $this->oRdb->numRows();

		$this->oRdb->closeStmt();

		return array(
			'bExito'	=> true,
			'nCodigo'	=> 0,
			'sMensaje'	=> 'Consulta Exitosa',
			'data'		=> $data,
			'nTotal'	=> $count
		);

	} # consultar

	public function eliminar(){
		$array_params = array(
			array(
				'name'	=> 'nIdDeposito',
				'type'	=> 'i',
				'value'	=> self::getIdDeposito()
			)
		);

		$this->oWdb->setSDatabase('redefectiva');
		$this->oWdb->setSStoredProcedure('sp_delete_deposito');
		$this->oWdb->setParams($array_params);

		$arrRes = $this->oWdb->execute();

		if($arrRes['nCodigo'] > 0 || $arrRes['bExito'] == false){
			return $arrRes;
		}

		$this->oWdb->closeStmt();

		return array(
			'bExito'	=> true,
			'nCodigo'	=> 0,
			'sMensaje'	=> 'Deposito Eliminado',
			'data'		=> array(),
			'nTotal'	=> 0
		);
	}

	public function insertar(){
		$array_params = array(
			array(
				'name'	=> 'nNumCuenta',
				'value'	=> self::getNumCuenta(),
				'type'	=> 's'
			),
			array(
				'name'	=> 'nImporte',
				'value'	=> self::getImporte(),
				'type'	=> 'd'
			),
			array(
				'name'	=> 'tipoDeposito',
				'value'	=> self::getTipoDeposito(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'dFecha',
				'value'	=> self::getFechaDeposito(),
				'type'	=> 's'
			),
			array(
				'name'	=> 'dFecha',
				'value'	=> self::getFechaDeposito(),
				'type'	=> 's'
			),
			array(
				'name'	=> 'autorizacion',
				'value'	=> self::getAutorizacion(),
				'type'	=> 's'
			),
			array(
				'name'	=> 'nIdUsuario',
				'value'	=> self::getIdUsuario(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nIdBanco',
				'value'	=> self::getIdBanco(),
				'type'	=> 'i'
			)
		);

		$this->oWdb->setSDatabase('data_webpos');
		$this->oWdb->setSStoredProcedure('SPE_PREDEPOSITO');
		$this->oWdb->setParams($array_params);

		$arrRes = $this->oWdb->execute();

		if($arrRes['nCodigo'] > 0 || $arrRes['bExito'] == false){
			return $arrRes;
		}

		$this->oWdb->closeStmt();

		return array(
			'bExito'	=> true,
			'nCodigo'	=> 0,
			'sMensaje'	=> 'Deposito Capturado',
			'data'		=> array(),
			'nTotal'	=> 0
		);
	} # insertar

	/*
		Consulta los depositos registrados erroneamente, ejemplo autorizacion BANCOMER y id de banco = 2
	*/
	public function consultarError($sBuscar, $nStart, $nLimit){
		$array_params = array(
			array(
				'name'	=> 'nIdBanco',
				'type'	=> 'i',
				'value'	=> self::getIdBanco()
			),
			array(
				'name'	=> 'nIdDeposito',
				'type'	=> 'i',
				'value'	=> self::getIdDeposito()
			),
			array(
				'name'	=> 'dFechaInicio',
				'type'	=> 's',
				'value'	=> self::getDFechaInicio()
			),
			array(
				'name'	=> 'dFechaFinal',
				'type'	=> 's',
				'value'	=> self::getDFechaFinal()
			),
			array(
				'name'	=> 'nIdEstatus',
				'type'	=> 's',
				'value'	=> self::getIdEstatus()
			),
			array(
				'name'	=> 'nNumCuenta',
				'type'	=> 's',
				'value'	=> self::getNumCuenta()
			),
			array(
				'name'	=> 'sStrBusqueda',
				'type'	=> 's',
				'value'	=> $sBuscar
			),
			array(
				'name'	=> 'nStart',
				'type'	=> 's',
				'value'	=> $nStart
			),
			array(
				'name'	=> 'nLimit',
				'type'	=> 's',
				'value'	=> $nLimit
			)
		);

		$this->oRdb->setSDatabase('redefectiva');
		$this->oRdb->setSStoredProcedure('sp_select_depositoserror');
		$this->oRdb->setParams($array_params);
		$arrRes	= $this->oRdb->execute();

		if($arrRes['nCodigo'] > 0 || $arrRes['bExito'] == false){
			return $arrRes;
		}

		$data		= $this->oRdb->fetchAll();
		$num_rows	= $this->oRdb->numRows();
		$this->oRdb->closeStmt();

		$found_rows	= $this->oRdb->foundRows();

		$this->oRdb->closeStmt();

		return array(
			'bExito'	=> true,
			'nCodigo'	=> 0,
			'sMensaje'			=> 'Consulta Exitosa',
			'sMensajeDetallado'	=> 'Consulta Exitosa',
			'data'				=> $data,
			'num_rows'			=> $num_rows,
			'found_rows'		=> $found_rows
		);
	} # consultarError

	/*
		Actualiza el id de banco de un depósito
	*/
	public function corregirBanco(){
		$array_params = array(
			array(
				'name'	=> 'nIdDeposito',
				'value'	=> self::getIdDeposito(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nIdBanco',
				'value'	=> self::getIdBanco(),
				'type'	=> 'i'
			)
		);

		$this->oWdb->setSDatabase('redefectiva');
		$this->oWdb->setSStoredProcedure('sp_update_depositoerror');
		$this->oWdb->setParams($array_params);

		$arrRes = $this->oWdb->execute();

		if($arrRes['nCodigo'] > 0 || $arrRes['bExito'] == false){
			return $arrRes;
		}

		$data = $this->oWdb->fetchAll();

		$this->oWdb->closeStmt();

		return array(
			'bExito'	=> $data[0]['nCodigo'] == 0? true : false,
			'nCodigo'	=> $data[0]['nCodigo'],
			'sMensaje'	=> $data[0]['sMensaje'],
			'data'		=> $data,
			'nTotal'	=> 0
		);
	} # corregirBanco
} # Deposito

?>