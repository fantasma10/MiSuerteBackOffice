<?php

class Notificacion{

	public $nIdNotificacion;
	public $nIdEstatus;
	public $nIdArea;
	public $sCorreo;
	public $nIdUsuario;
	public $oRdb;
	public $oWdb;

	public function setNIdNotificacion($value){
		$this->nIdNotificacion = $value;
	}

	public function getNIdNotificacion(){
		return $this->nIdNotificacion;
	}

	public function setNIdEstatus($value){
		$this->nIdEstatus = $value;
	}

	public function getNIdEstatus(){
		return $this->nIdEstatus;
	}

	public function setNIdArea($value){
		$this->nIdArea = $value;
	}

	public function getNIdArea(){
		return $this->nIdArea;
	}

	public function setSCorreo($value){
		$this->sCorreo = $value;
	}

	public function getSCorreo(){
		return $this->sCorreo;
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

	# # # # # # # # # # # # # # # # # # # # # #

	public function guardar(){
		$array_params = array(
			array(
				'name'	=> 'nIdArea',
				'value'	=> self::getNIdArea(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'sCorreo',
				'value'	=> self::getSCorreo(),
				'type'	=> 's'
			),
			array(
				'name'	=> 'nIdUsuario',
				'value'	=> self::getNIdUsuario(),
				'type'	=> 'i'
			)
		);

		$this->oWdb->setSDatabase('pronosticos');
		$this->oWdb->setSStoredProcedure('sp_insert_notificacion');
		$this->oWdb->setParams($array_params);

		$resultado = $this->oWdb->execute();

		if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
			return $resultado;
		}

		$this->oWdb->closeStmt();

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> 'Datos guardados Correctamente',
			'sMensajeDetallado'	=> '',
			'data'				=> array()
		);
	} # guardar

	public function actualizar(){
		$array_params = array(
			array(
				'name'	=> 'nIdNotificacion',
				'value'	=> self::getNIdNotificacion(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nIdArea',
				'value'	=> self::getNIdArea(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'sCorreo',
				'value'	=> self::getSCorreo(),
				'type'	=> 's'
			)
		);

		$this->oWdb->setSDatabase('pronosticos');
		$this->oWdb->setSStoredProcedure('sp_update_notificacion');
		$this->oWdb->setParams($array_params);

		$resultado = $this->oWdb->execute();

		if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
			return $resultado;
		}

		$this->oWdb->closeStmt();

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> 'Datos guardados Correctamente',
			'sMensajeDetallado'	=> '',
			'data'				=> array()
		);
	} # actualizar

	public function consultar($oCfgTabla){
		$array_params = array(
			array(
				'name'	=> 'nIdNotificacion',
				'value'	=> self::getNIdNotificacion(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'str',
				'value'	=> utf8_decode($oCfgTabla->str),
				'type'	=> 's'
			),
			array(
				'name'	=> 'start',
				'value'	=> $oCfgTabla->start,
				'type'	=> 'i'
			),
			array(
				'name'	=> 'limit',
				'value'	=> $oCfgTabla->limit,
				'type'	=> 'i'
			),
			array(
				'name'	=> 'sortCol',
				'value'	=> $oCfgTabla->sortCol,
				'type'	=> 'i'
			),
			array(
				'name'	=> 'sortDir',
				'value'	=> $oCfgTabla->sortDir,
				'type'	=> 's'
			)
		);
		#echo '<pre>'; var_dump($array_params); echo '</pre>';
		$this->oWdb->setSDatabase('pronosticos');
		$this->oWdb->setSStoredProcedure('sp_select_notificacion');
		$this->oWdb->setParams($array_params);

		$resultado = $this->oWdb->execute();

		if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
			return $resultado;
		}

		$data		= $this->oWdb->fetchAll();
		$num_rows	= $this->oWdb->numRows();

		$this->oWdb->closeStmt();

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> 'Consulta Ok',
			'sMensajeDetallado'	=> '',
			'data'				=> $data,
			'num_rows'			=> $num_rows
		);
	} # consultar

	public function eliminar(){
		$array_params = array(
			array(
				'name'	=> 'nIdNotificacion',
				'value'	=> self::getNIdNotificacion(),
				'type'	=> 'i'
			)
		);

		$this->oWdb->setSDatabase('pronosticos');
		$this->oWdb->setSStoredProcedure('sp_delete_notificacion');
		$this->oWdb->setParams($array_params);

		$resultado = $this->oWdb->execute();

		if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
			return $resultado;
		}

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> 'Eliminado Correctamente',
			'sMensajeDetallado'	=> '',
			'data'				=> array()
		);
	} # eliminar
} # Notificacion

?>