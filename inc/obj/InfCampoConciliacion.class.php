<?php

class InfCampoConciliacion{

	public $nId;
	public $nIdEstatus;
	public $nIdCadena;
	public $nIdCampo;
	public $nPosicionInicial;
	public $nPosicionFinal;
	public $sValorComparar;
	public $dFecRegistro;
	public $dFecMovimiento;
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

	public function setNIdCadena($value){
		$this->nIdCadena = $value;
	}

	public function getNIdCadena(){
		return $this->nIdCadena;
	}

	public function setNIdCampo($value){
		$this->nIdCampo = $value;
	}

	public function getNIdCampo(){
		return $this->nIdCampo;
	}

	public function setNPosicionInicial($value){
		$this->nPosicionInicial = $value;
	}

	public function getNPosicionInicial(){
		return $this->nPosicionInicial;
	}

	public function setNPosicionFinal($value){
		$this->nPosicionFinal = $value;
	}

	public function getNPosicionFinal(){
		return $this->nPosicionFinal;
	}

	public function setSValorComparar($value){
		$this->sValorComparar = $value;
	}

	public function getSValorComparar(){
		return $this->sValorComparar;
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
		Inserta o actualiza el campo
		Si no existe lo inserta, si existe lo actualiza
	*/
	public function sp_update_campo(){

		$array_params = array(
			array(
				'name'		=> 'nIdCadena',
				'value'		=> self::getNIdCadena(),
				'type'		=> 'i'
			),
			array(
				'name'		=> 'nIdCampo',
				'value'		=> self::getNIdCampo(),
				'type'		=> 'i'
			),
			array(
				'name'		=> 'nPosicionInicial',
				'value'		=> self::getNPosicionInicial(),
				'type'		=> 'i'
			),
			array(
				'name'		=> 'nPosicionFinal',
				'value'		=> self::getNPosicionFinal(),
				'type'		=> 'i'
			),
			array(
				'name'		=> 'sValorComparar',
				'value'		=> self::getSValorComparar(),
				'type'		=> 's'
			)
		);

		$this->oWdb->setSDatabase('data_contable');
		$this->oWdb->setSStoredProcedure('sp_update_cliente_campo');
		$this->oWdb->setParams($array_params);

		$resultado = $this->oWdb->execute();

		if(!$resultado['bExito'] || $resultado['nCodigo'] != 0){
			$resultado['sMensaje'] = 'No ha sido posible guardar la informacion';
			return $resultado;
		}

		$data = $this->oWdb->fetchAll();
		$this->oWdb->closeStmt();

		$datos = $data[0];

		$nCodigo	= $datos['nCodigo'];
		$sMensaje	= $datos['sMensaje'];

		return array(
			'bExito'			=> ($nCodigo == 0)? true : false,
			'nCodigo'			=> $nCodigo,
			'sMensaje'			=> $sMensaje,
			'sMensajeDetallado'	=> $sMensaje,
			'data'				=> $data,
			'found_rows'		=> 0
		);
	} # sp_update_campo

	public function sp_eliminar_campo(){
		$array_params = array(
			array(
				'name'	=> 'nIdCadena',
				'value'	=> self::getNIdCadena(),
				'type'	=> 'i'
			),
			array(
				'name'		=> 'nIdCampo',
				'value'		=> self::getNIdCampo(),
				'type'		=> 'i'
			)
		);

		$this->oWdb->setSDatabase('data_contable');
		$this->oWdb->setSStoredProcedure('sp_delete_cliente_campo');
		$this->oWdb->setParams($array_params);

		$resultado = $this->oWdb->execute();

		if(!$resultado['bExito'] || $resultado['nCodigo'] != 0){
			$resultado['sMensaje'] = 'No ha sido posible guardar la informacion';
			return $resultado;
		}

		$data = array();

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> '',
			'sMensajeDetallado'	=> '',
			'data'				=> $data,
			'found_rows'		=> 0
		);
	} # sp_eliminar_campo

} # PC_InfCampoConciliacion

?>