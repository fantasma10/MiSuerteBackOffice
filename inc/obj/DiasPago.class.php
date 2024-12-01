<?php

class DiasPago{

	public $nIdConfPago;
	public $nIdUsuario;
	public $nIdMetodoPago;
	public $nIdDia;
	public $oRdb;
	public $oWdb;

	public function setNIdConfPago($value){
		$this->nIdConfPago = $value;
	}

	public function getNIdConfPago(){
		return $this->nIdConfPago;
	}

	public function setNIdUsuario($value){
		$this->nIdUsuario = $value;
	}

	public function getNIdUsuario(){
		return $this->nIdUsuario;
	}

	public function setNIdMetodoPago($value){
		$this->nIdMetodoPago = $value;
	}

	public function getNIdMetodoPago(){
		return $this->nIdMetodoPago;
	}

	public function setNIdDia($value){
		$this->nIdDia = $value;
	}

	public function getNIdDia(){
		return $this->nIdDia;
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

	# # # # # # # # # # # # # # # # # #

	public function eliminarDiasPago(){
		$array_params = array(
			array(
				'name'	=> 'nIdMetodoPago',
				'value'	=> self::getNIdMetodoPago(),
				'type'	=> 'i'
			)
		);

		$this->oWdb->setSDatabase('pronosticos');
		$this->oWdb->setSStoredProcedure('sp_delete_diaspago');
		$this->oWdb->setParams($array_params);
		$resultado = $this->oWdb->execute();

		$this->oWdb->closeStmt();

		if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
			return $resultado;
		}

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> 'Dias Eliminados Correctamente',
			'sMensajeDetallado'	=> '',
			'data'				=> array()
		);
	} # eliminarDiasPago

	public function insertarDiaPago(){
		$array_params = array(
			array(
				'name'	=> 'nIdMetodoPago',
				'value'	=> self::getNIdMetodoPago(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nIdDia',
				'value'	=> self::getNIdDia(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nIdUsuario',
				'value'	=> self::getNIdUsuario(),
				'type'	=> 'i'
			)
		);

		$this->oWdb->setSDatabase('pronosticos');
		$this->oWdb->setSStoredProcedure('sp_insert_diaspago');
		$this->oWdb->setParams($array_params);
		$resultado = $this->oWdb->execute();

		$this->oWdb->closeStmt();

		if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
			return $resultado;
		}

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> 'Dias Insertado Correctamente',
			'sMensajeDetallado'	=> '',
			'data'				=> array()
		);
	} # insertarDiaPago

	public function consultarDiasPago(){
		$array_params = array(
			array(
				'name'	=> 'nIdMetodoPago',
				'value'	=> self::getNIdMetodoPago(),
				'type'	=> 'i'
			)
		);

		$this->oWdb->setSDatabase('pronosticos');
		$this->oWdb->setSStoredProcedure('sp_select_diaspago');
		$this->oWdb->setParams($array_params);

		$resultado = $this->oWdb->execute();

		if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
			return $resultado;
		}

		$data = $this->oWdb->fetchAll();

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> 'Dias Insertado Correctamente',
			'sMensajeDetallado'	=> '',
			'data'				=> $data
		);

	} # consultarDiasPago
}# DiasPago

?>