<?php

class Cat_Regimen{

	public $nIdRegimen;
	public $sNombre;
	public $nIdEstatus;
	public $oRdb;
	public $oWdb;

	public function setNIdRegimen($value){
		$this->nIdRegimen = $value;
	}

	public function getNIdRegimen(){
		return $this->nIdRegimen;
	}

	public function setSNombre($value){
		$this->sNombre = $value;
	}

	public function getSNombre(){
		return $this->sNombre;
	}

	public function setNIdEstatus($value){
		$this->nIdEstatus = $value;
	}

	public function getNIdEstatus(){
		return $this->nIdEstatus;
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
		Obtiene la lista de regimen
	*/
	public function sp_select_regimen(){
		$array_params = array();

		$this->oRdb->setSDatabase('paycash_one');
		$this->oRdb->setSStoredProcedure('sp_select_regimen');
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
	} # sp_select_regimen
} # Cat_Regimen

?>