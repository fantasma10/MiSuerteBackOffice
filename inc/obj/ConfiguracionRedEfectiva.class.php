<?php

class ConfiguracionRedEfectiva{

	public $nIdConfiguracion;
	public $nIdEstatus;
	public $sCLABERetiro;
	public $sCLABEDeposito;
	public $nTiempoActualizacion;
	public $nTiempoInactividad;
	public $nTiempoAlerta;
	public $nIdUsuario;
	public $oRdb;
	public $oWdb;
	public $nNumCuentaContableDeposito;

	public function setNNumCuentaContableDeposito($value){
		$this->nNumCuentaContableDeposito = $value;
	}

	public function getNNumCuentaContableDeposito(){
		return $this->nNumCuentaContableDeposito;
	}

	public function setNIdConfiguracion($value){
		$this->nIdConfiguracion = $value;
	}

	public function getNIdConfiguracion(){
		return $this->nIdConfiguracion;
	}

	public function setNIdEstatus($value){
		$this->nIdEstatus = $value;
	}

	public function getNIdEstatus(){
		return $this->nIdEstatus;
	}

	public function setSCLABERetiro($value){
		$this->sCLABERetiro = $value;
	}

	public function getSCLABERetiro(){
		return $this->sCLABERetiro;
	}

	public function setSCLABEDeposito($value){
		$this->sCLABEDeposito = $value;
	}

	public function getSCLABEDeposito(){
		return $this->sCLABEDeposito;
	}

	public function setNTiempoActualizacion($value){
		$this->nTiempoActualizacion = $value;
	}

	public function getNTiempoActualizacion(){
		return $this->nTiempoActualizacion;
	}

	public function setNTiempoInactividad($value){
		$this->nTiempoInactividad = $value;
	}

	public function getNTiempoInactividad(){
		return $this->nTiempoInactividad;
	}

	public function setNTiempoAlerta($value){
		$this->nTiempoAlerta = $value;
	}

	public function getNTiempoAlerta(){
		return $this->nTiempoAlerta;
	}

	public function setNIdUsuario($value){
		$this->nIdUsuario = $value;
	}

	public function getNIdUsuario(){
		return $this->nIdUsuario;
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

	public function guardar(){
		$array_params = array(
			array(
				'name'	=> 'sCLABERetiro',
				'value'	=> self::getSCLABERetiro(),
				'type'	=> 's'
			),
			array(
				'name'	=> 'sCLABEDeposito',
				'value'	=> self::getSCLABEDeposito(),
				'type'	=> 's'
			),
			array(
				'name'	=> 'nTiempoActualizacion',
				'value'	=> self::getNTiempoActualizacion(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nTiempoInactividad',
				'value'	=> self::getNTiempoInactividad(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nTiempoAlerta',
				'value'	=> self::getNTiempoAlerta(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nIdUsuario',
				'value'	=> self::getNIdUsuario(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nNumCuentaContableDeposito',
				'value'	=> self::getNNumCuentaContableDeposito(),
				'type'	=> 's'
			)
		);

		$this->oWdb->setSDatabase('pronosticos');
		$this->oWdb->setSStoredProcedure('sp_insert_configuracion');
		$this->oWdb->setParams($array_params);
		$resultado = $this->oWdb->execute();

		if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
			return $resultado;
		}

		$nIdConfiguracion = $this->oWdb->lastInsertId();

		$this->oWdb->closeStmt();

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> 'Datos Guardados Correctamente',
			'sMensajeDetallado'	=> '',
			'data'				=> array(
				'nIdConfiguracion' => $nIdConfiguracion
			)
		);
	} # guardar

	public function actualizar(){
		$array_params = array(
			array(
				'name'	=> 'nIdConfiguracion',
				'value'	=> self::getNIdConfiguracion(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'sCLABERetiro',
				'value'	=> self::getSCLABERetiro(),
				'type'	=> 's'
			),
			array(
				'name'	=> 'sCLABEDeposito',
				'value'	=> self::getSCLABEDeposito(),
				'type'	=> 's'
			),
			array(
				'name'	=> 'nTiempoActualizacion',
				'value'	=> self::getNTiempoActualizacion(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nTiempoInactividad',
				'value'	=> self::getNTiempoInactividad(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nTiempoAlerta',
				'value'	=> self::getNTiempoAlerta(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nIdUsuario',
				'value'	=> self::getNIdUsuario(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nNumCuentaContableDeposito',
				'value'	=> self::getNNumCuentaContableDeposito(),
				'type'	=> 's'
			)
		);

		$this->oWdb->setSDatabase('pronosticos');
		$this->oWdb->setSStoredProcedure('sp_update_configuracion');
		$this->oWdb->setParams($array_params);
		$resultado = $this->oWdb->execute();

		if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
			return $resultado;
		}

		$nIdConfiguracion = self::getNIdConfiguracion();

		$this->oWdb->closeStmt();

		return array(
			'bExito'			=> false,
			'nCodigo'			=> 0,
			'sMensaje'			=> 'Datos Guardados Correctamente',
			'sMensajeDetallado'	=> '',
			'data'				=> array('nIdConfiguracion' => $nIdConfiguracion)
		);
	} # actualizar

	public function cargar(){
		$array_params = array(
			array(
				'name'	=> 'nIdConfiguracion',
				'value'	=> self::getNIdConfiguracion(),
				'type'	=> 'i'
			)
		);

		$this->oWdb->setSDatabase('pronosticos');
		$this->oWdb->setSStoredProcedure('sp_select_configuracion');
		$this->oWdb->setParams($array_params);
		$resultado = $this->oWdb->execute();

		if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
			return $resultado;
		}

		$data = $this->oWdb->fetchAll();
		$data = $data[0];

		$this->oWdb->closeStmt();

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> 'Informacion Consultada Correctamente',
			'sMensajeDetallado'	=> '',
			'data'				=> $data
		);
	} # cargar
} # ConfiguracionRedEfectiva

?>