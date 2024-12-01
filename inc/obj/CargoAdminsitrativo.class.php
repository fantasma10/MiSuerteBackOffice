<?php

class CargoAdministrativo{

	public $oRdb;
	public $oWdb;
	public $nNumCuenta;
	public $dFechaInicio;
	public $dFechaFinal;
	public $nIdMovimiento;
	public $nIdUsuario;

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

	public function setNNumCuenta($value){
		$this->nNumCuenta = $value;
	}

	public function getNNumCuenta(){
		return $this->nNumCuenta;
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

	public function setNIdMovimiento($nIdMovimiento){
		$this->nIdMovimiento = $nIdMovimiento;
	}

	public function getNIdMovimiento(){
		return $this->nIdMovimiento;
	}

	public function setNIdUsuario($nIdUsuario){
		$this->nIdUsuario = $nIdUsuario;
	}

	public function getNIdUsuario(){
		return $this->nIdUsuario;
	}


	/*
		Obtiene la lista del primer cargo de cada cuenta realizado por concepto de abono menor a minimo del deposito permitido
	*/
	public function obtenerCargosAbonoMenor($nStart, $nLimit){
		$array_parametros = array(
			array(
				'name'	=> 'nNumCuenta',
				'value'	=> self::getNNumCuenta(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'dFechaInicio',
				'value'	=> self::getDFechaInicio(),
				'type'	=> 's'
			),
			array(
				'name'	=> 'dFechaFinal',
				'value'	=> self::getDFechaFinal(),
				'type'	=> 's'
			),
			array(
				'name'	=> 'nStart',
				'value'	=> $nStart,
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nLimit',
				'value'	=> $nLimit,
				'type'	=> 'i'
			)
		);

		$this->oRdb->setSDatabase('redefectiva');
		$this->oRdb->setSStoredProcedure('sp_select_cargoporabonomenor');
		$this->oRdb->setParams($array_parametros);

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
	} # obtenerCargosAbonoMenor

	public function devolverCargo(){
		$array_parametros = array(
			array(
				'name'	=> 'nIdMovimiento',
				'value'	=> self::getNIdMovimiento(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nIdUsuario',
				'value'	=> self::getNIdUsuario(),
				'type'	=> 'i'
			)
		);

		$this->oWdb->setSDatabase('redefectiva');
		$this->oWdb->setSStoredProcedure('sp_update_devolvercargo');
		$this->oWdb->setParams($array_parametros);

		$resultado = $this->oWdb->execute();

		if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
			return $resultado;
		}

		$data = $this->oWdb->fetchAll();
		$this->oWdb->closeStmt();

		return array(
			'bExito'			=> $data[0]['nCodigo'] == 0? true : false,
			'nCodigo'			=> $data[0]['nCodigo'],
			'sMensaje'			=> $data[0]['sMensaje'],
			'sMensajeDetallado'	=> $data[0]['sMensaje'],
			'data'				=> $data
		);
	} # devolverCargo

} # CargoAdministrativo

?>